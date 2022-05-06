<?php namespace App\Services;

class FormatParser {


    // AAA{random2:a-f;1-4}bb{random4:zxcvbnm}kk{date:Y}

    // $parts = [
    //     [
    //         type => text,
    //         value => 'AAA'
    //     ],
    //     [
    //         type => counter,
    //         length => 4
    //     ],
    //     [
    //         type => random,
    //         length => 2
    //         range => 'abcdef1234'
    //     ],
    //     [
    //         type => random,
    //         length => 4
    //         range => 'zxcvbnm'
    //     ],
    //     [
    //         type => date,
    //         format => 'Y'
    //     ]

    // ]


    public function parse($numberFormat) {

        $parts = [];

        $i = 0;

        while (strlen($numberFormat) > 0) {
            

            // Atradām parametra sākumu
            if (substr($numberFormat, $i, 1) == '{') {

                
                // Viss līdz parametra sākumam ir teksts
                $parts[] = (object)[
                    'type' => 'text',
                    'value' => substr($numberFormat, 0, $i)
                ];

                // Novācam teksta daļu
                $numberFormat = substr($numberFormat, $i);
                $i = 0;

                
                // Meklējam parametra beigas
                $end = strpos($numberFormat, '}');
                $parts[] = $this->parseParameter($this->sanitizeParameter(substr($numberFormat, 0, $end+1)));

            
                // Novācam atrasto parametru
                $numberFormat = substr($numberFormat, $end+1);
                $i = 0;
            }
            else {
                $i++;
            }


            if ($i > strlen($numberFormat)) {
                
                $parts[] = (object)[
                    'type' => 'text',
                    'value' => $numberFormat
                ];

                break;
            }
            
        }
        

        return array_filter($parts);

    }

    /**
     * 3 veidu parametri
     *     random
     *     counter
     *     date
     * 
     * Katram parametram atgriežam tam atbilstošos argumentus
     */
    public function parseParameter($parameterFormat) {
        // Nosakām kāds parametrs tas ir
        if (substr($parameterFormat, 0, 7) == 'counter') {
            return (object)[
                'type' => 'counter',
                'length' => $this->getLength($parameterFormat, 'counter', 4)
            ];
        }
        else if (substr($parameterFormat, 0, 6) == 'random') {
            return (object)[
                'type' => 'random',
                'length' => $this->getLength($parameterFormat, 'random', 4),
                'range' => $this->getRangeArgument($parameterFormat, 'a-z')
            ];
        }
        else if (substr($parameterFormat, 0, 4) == 'date') {
            return (object)[
                'type' => 'date',
                'format' => $this->getArgumentsString($parameterFormat, 'Y-m-d')
            ];
        }
    }

    /**
     * Izvelkam garumu no parametra formāta
     * parameterFormat ir šāda struktūra
     * [name][length?]:[parametri]
     * Length ir option
     * Lenght seko uzreiz aiz parameterName
     */
    public function getLength($parameterFormat, $parameterName, $defaultLength) {
        $p = explode(':', $parameterFormat);

        $length = trim(substr($p[0], strlen($parameterName)));
        
        // Ja nav length, tad atgriežam default
        $length = intval($length);

        if ($length <= 0) {
            return $defaultLength;
        }

        return $length;
    }

    /**
     * a-f;1-4;asdasd
     */
    public function getRangeArgument($parameterFormat, $defaultRange) {
        $items = explode(';', $this->getArgumentsString($parameterFormat));

        $r = '';
        foreach ($items as $item) {
            $r .= $this->expandRange($item);
        }

        return $r == '' ? $this->expandRange($defaultRange) : $r;
    }

    public function getArgumentsString($parameterFormat, $defaultString='') {
        $p = explode(':', $parameterFormat);

        $r = count($p) > 1 ? $p[1] : '';

        return $r ? $r : $defaultString;
    }

    /**
     * Expandoma simbolu range, ja tāds ir
     * range sākums un beigas tiek atdalīts ar -
     * a-z
     * Ja nav simbola -, tad atgriežam to, kas tiek padots
     */
    public function expandRange($range) {
        $p = explode('-', $range);

        if (count($p) == 1) {
            return $range;
        }

        return implode('', range(trim($p[0]), trim($p[1])));
    }

    public function sanitizeParameter($p) {
        $p = trim($p);
        $p = trim($p, "{}");
        $p = trim($p);
        return $p;
    }
}