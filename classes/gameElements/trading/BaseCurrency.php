<?php

    /*
     * The MIT License
     *
     * Copyright 2016 Li Yicheng, Sun Yudong, and Walter Kong.
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
     * Description of BaseCurrency
     *
     * @author Li Yicheng <liyicheng340 [at] gmail [dot com]>
     */
    require_once("Currency.php");
    require_once("mysql/UniversalConnect.php");

    class BaseCurrency extends Currency
    {

        public function __construct()
        {
            $db = UniversalConnect::doConnect();
            $query = "SELECT * FROM currency WHERE currencyid = 1 LIMIT 1";
            $result = $db->query($query) or die($db->error);
            while($row = $result->fetch_assoc())
            {
                $this->id = $row["currencyid"];
                $this->name = $row["name"];
                $this->shortname = $row["shortname"];
                $this->buyValue = $row["buyvalue"];
                $this->sellValue = $row["sellvalue"];
            }
        }

    }
    