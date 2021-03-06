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
     * Description of NewsBoardProduct
     *
     * @author Li Yicheng <liyicheng340 [at] gmail [dot com]>
     */
    require_once("mysql/UniversalConnect.php");
    require_once("pageElements/ElementProduct.php");
    require_once("gameElements/GameEndedChecker.php");
    require_once("gameElements/trading/BaseCurrency.php");
    require_once("miscellaneous/FormatTimePassed.php");

    class NewsBoardProduct implements ElementProduct
    {

        private $newsCount, $return;

        public function __construct($NumberNews = 10)
        {
            $this->newsCount = intval($NumberNews);
            $this->return = "";
        }

        public function giveProduct()
        {
            $db = UniversalConnect::doConnect();
            date_default_timezone_set('Asia/Singapore');
            $this->return .= <<<HTML
            <div id="news">
                <div class="card-panel pink accent-2 z-depth-1">
                    <div class="card-title">NEWS</div>
                </div>
                <div class="relative">
                    <ul class="collapsible" data-collapsible="accordion">
                    <!-- OR <ul class="collapsible popout" data-collapsible="accordion"> -->
HTML;
            $query = "SELECT starttime FROM startendtime LIMIT 1";
            $result = $db->query($query);
            $row = $result->fetch_assoc();
            $startTime = $row["starttime"];
            if($this->newsCount !== 0)
                $query = "SELECT newstext, time FROM news WHERE time <= ".(time()-$startTime)." ORDER BY time DESC LIMIT $this->newsCount";
            else
                $query = "SELECT newstext, time FROM news WHERE time <= ".(time()-$startTime)." ORDER BY time DESC";
            $result = $db->query($query) or die($db->error);
            if($result->num_rows <= 0)
            {
                $this->return .= "<li><div class=\"collapsible-header\">";
                $this->return .= "There are no news reports at the moment.";
                $this->return .= "</div></li>";
            }
            while($row = $result->fetch_assoc())
            {
                $this->return .= "<li class=\"z-depth-1\">";

                $this->return .= "<div class=\"collapsible-header\">";
                $this->return .= "<b>".FormatTimePassed::format(intval($row["time"])+$startTime)."</b>";
                $this->return .= $row["newstext"]."</div>";

//                $this->return .= "<div class=\"collapsible-body\"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam eu tortor sed nulla porta fringilla. In risus tellus, dictum quis purus id, euismod lacinia elit. Vivamus ac viverra magna, eget accumsan mauris. Nulla molestie vulputate lectus sit amet rutrum. Sed tempus efficitur sagittis. Aenean ultricies quis sapien ut tempus. Pellentesque euismod nisl a felis interdum pharetra. Nullam id nisi in ante volutpat posuere.</p></div>"; // Add article info before this
                $this->return .= "</li>";
            }
            $this->return .= "</ul></div></div>";
            return $this->return;
        }

    }
    