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
     * Description of Dashboard
     *
     * @author Li Yicheng <liyicheng340 [at] gmail [dot com]>
     */
    require_once("authenticate/SessionAuthenticate.php");
    require_once("pageElements/header/HeaderFactory.php");
    require_once("pageElements/navbar/NavbarFactory.php");
    require_once("pageElements/currencyBoard/CurrencyBoardFactory.php");
    require_once("pageElements/newsBoard/NewsBoardFactory.php");
    require_once("pageElements/profileCard/ProfileCardFactory.php");
    require_once("pageElements/currencyChart/CurrencyChartFactory.php");
    require_once("gameElements/DatabasePurger.php");
    require_once("gameElements/trading/BaseCurrency.php");
    require_once("miscellaneous/GenerateRootPath.php");

    class Dashboard
    {

        private $baseCurrency, $secCurr;

        public function __construct()
        {
            $SessAuthWorker = new SessionAuthenticate();
            DatabasePurger::purge();
            if(!$SessAuthWorker->authenticate())
            {
                header("Location: ".GenerateRootPath::getRoot(2));
                exit();
            }
            if(isset($_POST["currid"]) && !GameEndedChecker::GameEnded())
            {
                $currid = intval($_POST["currid"]);
                if($currid > 1)
                {
                    if(isset($_POST["sellamt".$currid]) && isset($_POST["sellBase".$currid]))
                    {
                        $exceptionThrown = false;
                        try
                        {
                            $this->secCurr = new Currency($currid);
                        }
                        catch(Exception $e)
                        {
                            $exceptionThrown = true;
                        }
                        if(!$exceptionThrown)
                        {
                            $sellamt = round(floatval($_POST["sellamt".$currid] * 1000000), 2);
                            $this->secCurr->sell($sellamt);
                        }
                    }
                    else if(isset($_POST["buyamt".$currid]) && isset($_POST["buyBase".$currid]))
                    {
                        $exceptionThrown = false;
                        try
                        {
                            $this->secCurr = new Currency($currid);
                        }
                        catch(Exception $e)
                        {
                            $exceptionThrown = true;
                        }
                        if(!$exceptionThrown)
                        {
                            $buyamt = round(floatval($_POST["buyamt".$currid] * 1000000), 2);
                            $this->secCurr->buy($buyamt);
                        }
                    }
                }
            }
            $this->baseCurrency = new BaseCurrency();
            $headerFactory = new HeaderFactory();
            echo $headerFactory->startFactory(new HeaderProduct("Dashboard - Forex Trading Simulator", 2));
            ?>

            <body class="blue lighten-5">
                <script>
                    function changeHeight()
                    {
                        setTimeout(function ()
                        {
                            if($("#news ul").height() >= $("#news").height())
                            {
                                $("#news").addClass("active")
                            }
                            else
                            {
                                $("#news").removeClass("active");
                            }
                        }, 100)
                    }
                    window.onload = function ()
                    {
                        $(document).ready(function ()
                        {
                            // News card
                            Materialize.showStaggeredList('#news ul.collapsible');
                            changeHeight();
                            $(".collapsible-header").click(function ()
                            {
                                changeHeight()
                            });

                            // Mobile Sidenav
                            $('.button-collapse').sideNav({
                                menuWidth: 240, // Default is 240
                                edge: 'right', // Choose the horizontal origin
                                closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
                            });
                        })
                    }
                </script>
                <?php
                $navbarFactory = new NavbarFactory();
                echo $navbarFactory->startFactory(new NavbarProduct(2, 0));
                ?>
                <div class="container">
                    <div class="row">
                        <div class="col s12 m5 l4">
                            <?php
                            $profileCardFactory = new ProfileCardFactory();
                            echo $profileCardFactory->startFactory(new ProfileCardProduct(2));
                            $newsFactory = new NewsBoardFactory();
                            echo $newsFactory->startFactory(new NewsBoardProduct());
                            ?>
                        </div>
                        <div class="col s12 m7 l8">
                            <div class="card center">
                                <div class="card-content">
                                    <div class="card-title">
                                        <p><?php echo $this->baseCurrency->getShortName() ?>-JPY Bid Rates</p>
                                    </div>
                                    <?php
                                    //USD-JPY above is sloppy coding to be improved on when we need multiple currencies
                                    $currencyChartFactory = new CurrencyChartFactory();
                                    echo $currencyChartFactory->startFactory(new CurrencyChartProduct(2));
                                    ?>
                                </div>
                            </div>
                            <?php
                            $currencyBoardFactory = new CurrencyBoardFactory();
                            echo $currencyBoardFactory->startFactory(new CurrencyBoardProduct());
                            ?>
                        </div>
                    </div>
                </div>
            </body>
            <?php
        }

    }
?>