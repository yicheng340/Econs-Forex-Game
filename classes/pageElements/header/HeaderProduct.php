<?php

    /*
     * The MIT License
     *
     * Copyright 2015 Li Yicheng, Sun Yudong, and Walter Kong.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */

    /**
     * Description of HeaderProduct
     *
     * @author Li Yicheng <liyicheng340 [at] gmail [dot com]>
     */
    require_once("pageElements/ElementProduct.php");
    
    class HeaderProduct implements ElementProduct
    {
        private $title;
        private $extraScript;
        private $return;
        private $pathToRoot;

        public function __construct($HTMLtitle, $directoryLayer, $appendScript = "")
        {
            $this->title = $HTMLtitle;
            $this->extraScript = $appendScript;
            if($directoryLayer === 1)
                $this->pathToRoot = "./";
            else
                $this->pathToRoot = "../";
            for($i=1;$i<$directoryLayer;$i++)
            {
                $this->pathToRoot .= "../";
            }
        }

        public function giveProduct()
        {
            $this->return = <<<HEADER
<!--
The MIT License

Copyright 2015 Li Yicheng, Sun Yudong, and Walter Kong.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
-->
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>$this->title</title>
    <script>
        documentRoot = "./";
    </script>

    <script src="
HEADER;
            $this->return .= $this->pathToRoot;
            $this->return .= <<<HEADER
js/onerror.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js" onerror="this.onerror=null; this.src=resError(this.src)"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js" onerror="this.onerror=null; this.src=resError(this.src)"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css" media="screen,projection" onerror="this.onerror=null; this.src=resError(this.src)"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="
HEADER;
            $this->return .= $this->pathToRoot;
            $this->return .= <<<HEADER
css/main.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<<<<<<< HEAD
    <script>
        function failed(){
            $("#login-card").removeClass("failed")
                            .addClass("failed")
                            .delay(1000)
                            .queue(function() {
                                $(this).removeClass("failed");
                                $(this).dequeue();
                            });
        }
    </script>
</head>
=======
>>>>>>> 773c27031c33cf0c217b6d3cfe6d4a867d822bf2
HEADER;
            $this->return .= $this->extraScript."</head>";
            return $this->return;
        }
    }
    