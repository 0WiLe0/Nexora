@extends('layouts.app')

@section('title', 'Profile')

@section('content')

    <main class="profile-center">


        <section class="profile-card">
            <div class="profile-card__inner">

                <div class="profile-inner__block">

                    <div class="profile-avatar-block">
                        <div class="profile-avatar">


                            <img src="{{ $user->avatar }}" alt="Avatar">
                        </div>

                        <div class="profile-rank">
                            <img src="../img/ranks/silver_1.svg" alt="Rank">
                            <span>SILVER I</span>
                        </div>
                    </div>

                    <div class="profile-main-info">
                        <h1 class="profile-name">{{ $user->nickname }}</h1>

                        <div class="profile-meta">
                            <span>EU West</span>
                            <span class="dot"></span>
                            <span>ID: {{ $user->id }}</span>
                        </div>

                        <div class="profile-stats">
                            <div class="pstat">
                                <span class="pstat-label">WINRATE</span>
                                <span class="pstat-value green">57%</span>
                            </div>
                            <div class="pstat">
                                <span class="pstat-label">MATCHES</span>
                                <span class="pstat-value">1 240</span>
                            </div>
                            <div class="pstat">
                                <span class="pstat-label">MVP RATE</span>
                                <span class="pstat-value yellow">12%</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="profile-rating--block">

                    <div class="profile-rating">

                        <div class="valve-rating">
                            <div class="valve-title">VALVE MMR</div>
                            <span> ~ {{ $user->valve_mmr ?? '—' }}</span>
                        </div>

                        <div class="vline"></div>

                        <div class="nexora-rating">
                            <div class="nexora-title">NEXORA RATING</div>
                            <span>{{ $user->nexora_rating }}</span>
                        </div>

                    </div>

                    <div class="rating_difference">
                        RATING DIFFERENCE <span>+162</span>
                    </div>

                </div>

            </div>
        </section>

        <div class="match-wrapper">

            <div class="match_wrapper--title">
                MATCH HISTORY
            </div>

            <div class="match-row win">

                <div class="left_line"></div>

                <div class="left-side">
                    <img class="hero" src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/heroes/juggernaut_sb.png">

                    <div class="info">
                        <div class="result win">WIN <span class="duration">39:00</span></div>
                        <div class="kda">14/2/3  •  POS 2</div>
                    </div>
                </div>

                <div class="impact-side">
                    <div class="impact-title">
                        <span class="impact-label">PERF IMPACT</span>
                        <span class="impact-value red">-7 MMR</span>
                    </div>

                    <div class="impact-bar" data-impact="-7">
                        <div class="impact-center-line"></div>
                        <div class="impact-fill"></div>
                    </div>

                    <span class="impact-status">GOOD</span>
                </div>

                <div class="total-side">
                    <div class="total-label">TOTAL</div>
                    <div class="total-value green">+18</div>
                </div>

                <div class="arrow_stats">
                    <img src="../img/arrow.svg" class="toggle-arrow">
                </div>

            </div>

            <div class="match-stats hidden">

                <div class="stats-left">

                    <div class="stats-title">
                        <span>COMBAT & ECONOMY</span>
                    </div>

                    <div class="stats-grid">

                        <div class="stat-box">
                            <span class="stat-label">GPM</span>
                            <span class="stat-value">389</span>
                            <span class="stat-desc">ECONOMY</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-label">XPM</span>
                            <span class="stat-value">404</span>
                            <span class="stat-desc">EXPERIENCE</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-label">CS / DN</span>
                            <span class="stat-value">318/19</span>
                            <span class="stat-desc">CREEPS</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-label">KDA</span>
                            <span class="stat-value">8.50</span>
                            <span class="stat-desc">RATIO</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-label">HERO DMG</span>
                            <span class="stat-value">15.3k</span>
                            <span class="stat-desc">OUTPUT</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-label">TOWER DMG</span>
                            <span class="stat-value">3.4k</span>
                            <span class="stat-desc">OBJECTIVE</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-label">HEALING</span>
                            <span class="stat-value">749</span>
                            <span class="stat-desc">SUPPORT</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-label">WARDS</span>
                            <span class="stat-value">5/12</span>
                            <span class="stat-desc">VISION</span>
                        </div>

                    </div>
                </div>

                <div class="stats-right">

                    <div class="factor-container">

                        <div class="factor-row">
                            <span class="factor-name">Base Result (Win)</span>
                            <span class="factor-value green">+25</span>
                        </div>

                        <div class="factor-row">
                            <span class="factor-name">Perf. Index POS 2</span>
                            <span class="factor-value red">-7</span>
                        </div>

                        <div class="factor-total">
                            <span class="factor-name">NET MMR</span>
                            <span class="factor-value green">+18</span>
                        </div>

                    </div>

                </div>

            </div>

        </div>





    </main>

@endsection
