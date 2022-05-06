<?php namespace App\Services;

use \App\Models\Number;

use FormatParser;

class Numbers {

    /**
     * Cik piegājienos ir uzģenerēts numurs
     * Šis ir vajadzīgs, ja tiek veidoti numuri ar random string,
     * tad lai nodrošināu unikalitāti numurs tiek insertots datubāzē.
     * DB šajā mirklī atgriezīs kļūdu, ja tāds numnurs jau ir
     * Palielinam $generateTries un mēģinām vēlreiz
     * Ja ir numuri ar counter, tad šādas problēmas var rasties, ja kāds cits
     * uz šo pašu numura formātu arī ģenerē numuru
     */
    private $generateTries = 0;

    /**
     * Veidojam jaunu numuru ar norādītā formāta
     *
     * @param \App\Models\NumberFormat Numura formāts
     */
    public function create($format, $user) {
        // Sākot veidot numuru nonullējam mēģinājumu skaitu
        $this->generateTries = 0;
        
        
        return $this->getNewNumber($format, $user);
    }

    public function createByApiKey($format, $apiKey) {
        // Sākot veidot numuru nonullējam mēģinājumu skaitu
        $this->generateTries = 0;
        
        
        return $this->getNewNumber($format, $apiKey->user, $apiKey);
    }

    public function getNewNumber($format, $user, $apiKey=null) {
        $next = $this->getNextCounter($format);

        try {

            $number = Number::create([
                'number_format_id' => $format->id,
                'counter' => $next,
                'number' => $this->format($format->format, $next),
                'generate_tries' => $this->generateTries,
                'user_id' => $user->id,
                'api_key_id' => $apiKey ? $apiKey->id : null
            ]);

        } catch (\Illuminate\Database\QueryException $e) {

            if ($this->generateTries > 1000) {
                abort(500, 'Can not generate number');
            }

            $this->generateTries++;

            return $this->getNewNumber($format, $user);
        }

        return $number;
    }

    /**
     * Pēc norādītā numura formāta atgriežam nākošo counter
     * Nākošais counter vēl netiek saglabāts datubāzē
     */
    public function getNextCounter($format) {
        return intval(Number::where('number_format_id', '=', $format->id)->max('counter')) + 1;
    }

    /**
     * Veidojam random string noteiktā garumā ar noteiktiem simboliem
     * @param integer Garums
     * @param string simbolu virkne no kuras veidot numuru
     */
    public function generateRandomString($length, $chars) {
        $s = $chars;
        $s = str_shuffle($s);

        $len = strlen($s);

        $r = '';
        for ($i = 0; $i < $length; $i++) {
            $r .= substr(
                $s, 
                // Randomizējam arī char, kuru ņemt no range
                rand(0, $len-1),
                1
            );

            $s = str_shuffle($s);
        }

        return $r;
    }

    /**
     * Formatējam numuru pēc norādītā formāta ar norādīto counter
     */
    public function format($numberFormat, $counter=null) {
        $now = time();
        
        $numberParts = FormatParser::parse($numberFormat);

        $number = '';

        foreach ($numberParts as $part) {
            switch ($part->type) {
                case 'counter':
                    if ($counter) {
                        $number .= str_pad($counter, $part->length, '0', STR_PAD_LEFT);
                    }
                    break;
                case 'random':
                    $number .= $this->generateRandomString($part->length, $part->range);
                    break;
                case 'date':
                    $number .= date($part->format, $now);
                    break;
                case 'text':
                    $number .= $part->value;
            }
        }

        return $number;
    }
}