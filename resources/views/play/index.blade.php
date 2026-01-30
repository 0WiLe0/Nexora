@extends('layouts.app')

@section('title', 'Profile')

@section('content')

    <main class="ranked">

        <div class="ranked__wrapper">

            <!-- Фоновое видео/картинка -->
            <div class="ranked__background" style="background-image: url('{{ asset('img/background.png') }}')">

            </div>

            <!-- Верхний блок -->
            <div class="ranked__top">

                <div class="ranked__title">
                    <h1>RANKED</h1>
                    <span>NEXORA RATING</span>
                </div>

                <!-- Ранк -->
                <div class="ranked__stats">
                    <div class="ranked__rank">
                        <h3>CURRENT RANK</h3>
                        <div class="ranked__rank-points">
                            <span>1 240</span>
                            <div class="icon_rank">
                                <img src="../img/ranks/silver_1.svg" alt="">
                                <div class="bg_icon"></div>
                            </div>
                        </div>
                        <div class="ranked__rank-tier">
                            <span>GOLD 2</span>
                            <div class="amount_experience">
                                240 / 500
                            </div>
                        </div>
                        <div class="ranked__rank-progress">
                            <span style="width: 40%;"></span>
                        </div>
                    </div>

                    <div class="ranked__reputation">
                        <h3>REPUTATION</h3>
                        <div class="ranked__reputation-value">100</div>
                        <div class="ranked__reputation-grade">A+</div>
                        <div class="ranked__reputation-line">
                            <span style="width: 70%;"></span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="party">

                <div class="party__title">
                    <h4>PARTY</h4>
                    <button class="party-leave-btn">

                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2.21973H16V11.2197H19.5898L18.2939 9.92773L19.7061 8.51172L22.6855 11.4814L23.3955 12.1885L19.707 15.877L18.293 14.4629L19.5352 13.2197H16V23.2197H0V2.40039L0.803711 2.23926L12 0V2.21973ZM2 4.03906V21.2197H10V2.43945L2 4.03906ZM12 21.2197H14V4.21973H12V21.2197Z" fill="#973939" />
                        </svg>

                    </button>
                </div>

                <div class="party__slots"></div>

                <div class="party__roles"></div>


            </div>

            <!-- Нижний блок: роль / режим / сервер -->
            <div class="ranked__bottom">


                <div class="ranked__selector">

                    <div class="ranked__select-group">
                        <h4>SELECT ROLE</h4>
                        <div class="roles">

                            <div class="role--block" >
                                <button class="role js-role" data-role="carry">
                                    <img src="../img/roles/carry.svg" alt="">
                                </button>
                                <h3>CARRY</h3>
                            </div>


                            <div class="role--block" >
                                <button class="role js-role" data-role="mid">
                                    <img src="../img/roles/mid.svg" alt="">
                                </button>
                                <h3>MID</h3>
                            </div>

                            <div class="role--block">
                                <button class="role js-role"  data-role="offlane">
                                    <img src="../img/roles/offlane.svg" alt="">
                                </button>
                                <h3>OFFLANE</h3>
                            </div>

                            <div class="role--block" >
                                <button class="role js-role" data-role="support">
                                    <img src="../img/roles/soft.svg" alt="">
                                </button>
                                <h3>SOFT</h3>
                            </div>

                            <div class="role--block">
                                <button class="role js-role"  data-role="hard_support">
                                    <img src="../img/roles/hard.svg" alt="">
                                </button>
                                <h3>HARD</h3>
                            </div>



                        </div>
                    </div>

                </div>

                <div class="find__select">

                    <div class="find__select-group">
                        <h4>SELECT MODE</h4>
                        <div class="dropdown_modes js-mode-select">
                            <img class="icon_ranked_mode" src="../img/ranked_mode.svg" alt="">
                            <div class="modes_text">
                                <h5>MODE</h5>
                                <span class="js-mode-value">RANKED ALL PICK</span>
                            </div>
                            <div class="arrow_select_mode">
                                <img class="arrow" src="../img/arrow.svg" alt="">
                            </div>
                        </div>

                        <div class="dropdown_list js-mode-list hidden">
                            <div class="dropdown_item" data-mode="all_pick">RANKED ALL PICK</div>
                            <div class="dropdown_item" data-mode="turbo">RANKED TURBO</div>
                        </div>

                    </div>

                    <div class="find__select-group">
                        <h4>SELECT SERVER</h4>
                        <div class="dropdown_modes js-server-select">
                            <img class="icon_ranked_mode" src="../img/select_server.svg" alt="">
                            <div class="modes_text">
                                <h5>REGION</h5>
                                <span class="js-server-value">US West</span>
                            </div>
                            <div class="arrow_select_server">
                                <img class="arrow" src="../img/arrow.svg" alt="">
                            </div>
                        </div>

                        <div class="dropdown_list js-server-list hidden">
                            <div class="dropdown_item" data-server="us_west">US West</div>
                            <div class="dropdown_item" data-server="eu_west">EU West</div>
                            <div class="dropdown_item" data-server="stockholm">Stockholm</div>
                        </div>

                    </div>

                    <button class="ranked__find">
                        <img src="../img/play_btn.svg" alt="" class="icon_play_btn">
                        <div class="ranked__find-text">
                            <h2>FIND MATCH</h2>
                            <span>READY TO BATTLE</span>
                        </div>
                    </button>

                </div>


            </div>

        </div>

        <div class="search-play__block hidden">
            <div class="search-play">

                <div class="circle-search__play">
                    <div class="timer-play">00:00</div>
                    <span class="timer-text">SEARCH</span>
                </div>

                <h3 class="search-title__block">GAME SEARCH</h3>

                <div class="server-mode__block">
                    <div class="server-search__block">

                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.33398 0C11.3839 0.000175807 14.667 3.284 14.667 7.33398C14.6668 11.3838 11.3838 14.6668 7.33398 14.667C3.284 14.667 0.000175804 11.3839 0 7.33398C0 3.2839 3.2839 0 7.33398 0ZM1.37207 8.00098C1.64636 10.4792 3.42897 12.5014 5.78223 13.1299C4.75341 11.6121 4.14361 9.84299 4.02441 8.00098H1.37207ZM10.6426 8.00098C10.5234 9.84304 9.91361 11.6121 8.88477 13.1299C11.2384 12.5016 13.0216 10.4794 13.2959 8.00098H10.6426ZM5.36035 8.00098C5.49619 9.82504 6.1844 11.5639 7.33301 12.9863C8.48193 11.5638 9.17151 9.8252 9.30762 8.00098H5.36035ZM5.78125 1.53711C3.42823 2.16579 1.64621 4.18887 1.37207 6.66699H4.02441C4.14354 4.8249 4.75251 3.05507 5.78125 1.53711ZM7.33301 1.67969C6.18394 3.10235 5.49605 4.84232 5.36035 6.66699H9.30762C9.17165 4.84216 8.48238 3.10246 7.33301 1.67969ZM8.88477 1.53711C9.91371 3.05517 10.5234 4.8247 10.6426 6.66699H13.2959C13.0217 4.18833 11.2386 2.16532 8.88477 1.53711Z" fill="#8997AA" />
                        </svg>

                        <span class="server-search__text">EU WEST</span>

                    </div>

                    <div class="server-mode__line"></div>

                    <div class="gamemode-search__block">

                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.5293 7.52832C1.78965 7.26797 2.21231 7.26797 2.47266 7.52832L5.13867 10.1953C5.39902 10.4557 5.39902 10.8773 5.13867 11.1377C4.87832 11.398 4.45664 11.398 4.19629 11.1377L3.66699 10.6084L2.27539 12L2.47168 12.1963C2.73187 12.4567 2.73197 12.8784 2.47168 13.1387C2.21138 13.399 1.78966 13.3989 1.5293 13.1387L0.195312 11.8057C-0.065037 11.5453 -0.065037 11.1227 0.195312 10.8623C0.455662 10.602 0.878322 10.602 1.13867 10.8623L1.33203 11.0557L2.72363 9.66504L1.5293 8.47168C1.26895 8.21133 1.26895 7.78867 1.5293 7.52832ZM2.79785 0.0136719C2.92589 0.0393206 3.04497 0.101609 3.13867 0.195312L10.333 7.38965L10.8613 6.8623C11.1217 6.60196 11.5443 6.60196 11.8047 6.8623C12.065 7.12265 12.065 7.54531 11.8047 7.80566L10.2754 9.33398L11.999 11.0576L12.1953 10.8623C12.4556 10.6023 12.8774 10.6022 13.1377 10.8623C13.398 11.1227 13.398 11.5453 13.1377 11.8057L11.8047 13.1387C11.5443 13.399 11.1217 13.399 10.8613 13.1387C10.6012 12.8784 10.6014 12.4566 10.8613 12.1963L11.0566 12L9.33301 10.2764L7.80469 11.8057C7.54434 12.066 7.12168 12.066 6.86133 11.8057C6.60098 11.5453 6.60098 11.1227 6.86133 10.8623L7.38965 10.333L0.195312 3.13867C0.0702883 3.01365 0 2.8438 0 2.66699V0.666992C0 0.298802 0.298802 0 0.666992 0H2.66699L2.79785 0.0136719ZM1.33398 2.39062L8.33301 9.38965L9.38965 8.33301L2.39062 1.33398H1.33398V2.39062ZM12.666 0C13.0342 0 13.333 0.298802 13.333 0.666992V2.66699C13.333 2.8438 13.2627 3.01365 13.1377 3.13867L10.8047 5.47168C10.5443 5.73203 10.1217 5.73203 9.86133 5.47168C9.60125 5.21143 9.60136 4.78962 9.86133 4.5293L12 2.39062V1.33398H10.9424L8.80469 3.47168C8.54434 3.73203 8.12168 3.73203 7.86133 3.47168C7.60125 3.21143 7.60136 2.78962 7.86133 2.5293L10.1953 0.195312L10.2969 0.112305C10.4054 0.0399883 10.5336 6.45254e-05 10.666 0H12.666Z" fill="#8997AA" />
                        </svg>

                        <span class="gamemode-search__text">RANKED ALL PICK</span>
                    </div>
                </div>

                <button class="cancel-search__btn">
                    CANCEL SEARCH
                </button>

            </div>
        </div>

        <div class="accept-play__block hidden">
            <div class="accept-play">

                <div class="accept-signature">
                    MATCH FOUND
                </div>

                <h3 class="title-accept__block">
                    READY?
                </h3>

                <button class="accept-btn">

                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.1084 20.6045C4.69418 20.0187 5.64371 20.0187 6.22949 20.6045L13.5625 27.9375C14.1483 28.5233 14.1483 29.4728 13.5625 30.0586C12.9767 30.6444 12.0272 30.6444 11.4414 30.0586L9.75 28.3672L5.45312 32.6641L6.22754 33.4385C6.81333 34.0243 6.81333 34.9748 6.22754 35.5605C5.64175 36.1463 4.69126 36.1463 4.10547 35.5605L0.439453 31.8936C-0.146333 31.3078 -0.146333 30.3582 0.439453 29.7725C1.02524 29.1867 1.97476 29.1867 2.56055 29.7725L3.33203 30.543L7.62891 26.2461L4.1084 22.7256C3.52261 22.1398 3.52261 21.1903 4.1084 20.6045ZM7.14844 0.0078125C7.49167 0.0419849 7.8145 0.193406 8.06055 0.439453L28.0811 20.46L29.7695 18.7725C30.3553 18.1868 31.3049 18.1867 31.8906 18.7725C32.4762 19.3582 32.4762 20.3078 31.8906 20.8936L29.1689 23.6143C29.1601 23.6236 29.1527 23.6344 29.1436 23.6436C29.1344 23.6527 29.1236 23.6601 29.1143 23.6689L27.4512 25.3311L32.665 30.5449L33.4375 29.7725C34.0233 29.1867 34.9738 29.1867 35.5596 29.7725C36.1451 30.3582 36.1451 31.3078 35.5596 31.8936L31.8926 35.5605C31.3068 36.146 30.3572 36.146 29.7715 35.5605C29.1857 34.9748 29.1857 34.0243 29.7715 33.4385L30.5439 32.666L25.3301 27.4521L23.6689 29.1143C23.6601 29.1236 23.6527 29.1344 23.6436 29.1436C23.6344 29.1527 23.6236 29.1601 23.6143 29.1689L20.8906 31.8936C20.3049 32.4791 19.3553 32.4791 18.7695 31.8936C18.1838 31.3078 18.1839 30.3583 18.7695 29.7725L20.46 28.0811L0.439453 8.06055C0.158189 7.77928 4.5707e-05 7.39776 0 7V1.5C0 0.671573 0.671573 0 1.5 0H7L7.14844 0.0078125ZM3 6.37793L22.582 25.96L25.96 22.5811L6.37891 3H3V6.37793ZM34.4961 0C35.3245 0 35.9961 0.671573 35.9961 1.5V7C35.996 7.39776 35.8379 7.77928 35.5566 8.06055L29.1406 14.4766C28.5548 15.0623 27.6053 15.0623 27.0195 14.4766C26.4338 13.8908 26.4338 12.9412 27.0195 12.3555L32.9961 6.37891V3H29.6182L23.6406 8.97754C23.0549 9.56298 22.1053 9.56298 21.5195 8.97754C20.9337 8.39175 20.9337 7.44126 21.5195 6.85547L27.9355 0.439453C28.2167 0.158255 28.5984 0.000119288 28.9961 0H34.4961Z" fill="black" />
                    </svg>

                    <span class="accept-btn__title">ACCEPT</span>

                </button>

                <div class="your-group__accept">

                    <div class="personal-accept">
                        <img src="img/avatar.png" alt="">
                    </div>

                    <div class="personal-accept">
                        <img src="img/avatar.png" alt="">
                    </div>

                    <div class="personal-accept">
                        <img src="img/avatar.png" alt="">
                    </div>

                    <div class="personal-accept">
                        <img src="img/avatar.png" alt="">
                    </div>

                    <div class="personal-accept">
                        <img src="img/avatar.png" alt="">
                    </div>

                </div>

                <div class="progress-bar__accept">
                    <div class="progress"></div>
                </div>

                <div class="timer-accept">25 s</div>

            </div>
        </div>


        <div class="party-modal hidden">

            <div class="party-modal__overlay"></div>

            <div class="party-modal__content">

                <h3 class="party-modal__title ">INVITE FRIENDS</h3>

                <div class="party-modal__list invite-list"></div>

                <button class="party-modal__close">
                    CLOSE
                </button>

            </div>

        </div>


    </main>


@endsection
