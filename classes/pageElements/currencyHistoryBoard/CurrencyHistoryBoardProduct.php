<?php

    /*
     * The MIT License
     *
     * Copyright 2016 Li Yicheng, Walter Kong, and Sun Yudong.
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
     * Description of CurrencyHistoryBoardProduct
     *
     * @author Li Yicheng <liyicheng340 [at] gmail [dot com]>
     */
    require_once("mysql/UniversalConnect.php");
    require_once("pageElements/ElementProduct.php");
    require_once("miscellaneous/FormatTimePassed.php");
    
    class CurrencyHistoryBoardProduct implements ElementProduct
    {
        private $return;
        
        public function __construct()
        {
            $this->return = "";
        }
        
        public function giveProduct()
        {
            $this->return .= <<<HTML
                <div id="currencyHistoryBoard" class="card">
                <table style="width:100%">
                    <tr class="blue">
                        <th class="center">Currency</th>
                        <th class="center">Time</th>
                        <th class="center">Bid Rate</th>
                        <th class="center">Offer Rate</th>
                    </tr>
HTML;
            $db = UniversalConnect::doConnect();
            $query = "SELECT starttime FROM startendtime LIMIT 1";
            $result = $db->query($query);
            $row = $result->fetch_assoc();
            $startTime = $row["starttime"];
            $query = "SELECT currency.shortname, valuechanges.newbuyvalue, valuechanges.newsellvalue, valuechanges.time FROM valuechanges INNER JOIN currency ON valuechanges.currencyid = currency.currencyid WHERE valuechanges.yetcompleted=0 ORDER BY valuechanges.time DESC";
            $result = $db->query($query) or die($db->error);
            while($row = $result->fetch_assoc())
            {
                $this->return .= "<tr>";
                $this->return .= "<td class=\"center\">".$row["shortname"]."</td>";
                $this->return .= "<td class=\"center\">".FormatTimePassed::format($row["time"]+$startTime)."</td>";
                $this->return .= "<td class=\"center\">".number_format($row["newbuyvalue"], 2)."</td>";
                $this->return .= "<td class=\"center\">".number_format($row["newsellvalue"], 2)."</td>";
                $this->return .= "</tr>";
            }
            $this->return .= "</table></div>";
            return $this->return;
        }
    }
    