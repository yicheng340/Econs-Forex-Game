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
     * Description of Leaderboard
     *
     * @author Li Yicheng <liyicheng340 [at] gmail [dot com]>
     */
    require_once("authenticate/SessionAuthenticate.php");
    require_once("pageElements/header/HeaderFactory.php");
    require_once("pageElements/navbar/NavbarFactory.php");
    require_once("pageElements/profileCard/ProfileCardFactory.php");
    require_once("pageElements/leaderboard/LeaderboardFactory.php");
    require_once("gameElements/DatabasePurger.php");
    require_once("miscellaneous/GenerateRootPath.php");

    class Leaderboard
    {

        public function __construct()
        {
            if(session_status() === PHP_SESSION_NONE)
            {
                session_start();
            }
            $SessAuthWorker = new SessionAuthenticate();
            if(!$SessAuthWorker->authenticate())
            {
                header("Location: ".GenerateRootPath::getRoot(3));
                exit();
            }
            DatabasePurger::purge();
            $headerFactory = new HeaderFactory();
            echo $headerFactory->startFactory(new HeaderProduct("Leaderboards - Forex Trading Simulator", 3));
            ?>
            <body class="blue lighten-5">

                <?php
                $navbarFactory = new NavbarFactory();
                echo $navbarFactory->startFactory(new NavbarProduct(3, 20));
                ?>
                <div class="container">
                    <div class="row">
                        <div class="col s4">
                            <?php
                            $profileCardFactory = new ProfileCardFactory();
                            echo $profileCardFactory->startFactory(new ProfileCardProduct(3));
                            ?>
                        </div>
                        <div class="col s8">
                            <div class="row">
                                <div class="col s12">
                                    <?php
                                    $leaderboardWorker = new LeaderboardFactory();
                                    echo $leaderboardWorker->startFactory(new LeaderboardProduct());
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }

        }
        