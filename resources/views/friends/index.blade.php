@extends('layouts.app')

@section('title', 'Friends')

@section('content')

    <main class="fiends-center">

        <div class="friends_title">
            <h2>Friends</h2>
        </div>

        <div class="friends-top__block">

            <div class="search_block">
                <div class="search_icon">

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search text-slate-500" aria-hidden="true">
                        <path d="m21 21-4.34-4.34"></path>
                        <circle cx="11" cy="11" r="8"></circle>
                    </svg>

                </div>

                <input class="search-input" placeholder="Search Your Friends" type="text">

            </div>

            <div class="swap_block">
                <button class="swap_button swap_button--active" data-tab="friends">My Friend</button>
                <button class="swap_button" data-tab="global">Global Search</button>
                <button class="swap_button" data-tab="requests">Request</button>
            </div>

        </div>

        <section class="friends-cards" id="friends_tab">
            <div class="friends-cards__inner">



                @if($friends->isEmpty())
                    <div class="friends-empty" data-empty="base">
                        <h3>No friends yet</h3>
                    </div>
                @else
                    @foreach($friends as $friend)
                        @php
                            $friendUser = $friend->requester_id === auth()->id()
                                ? $friend->addresseeUser
                                : $friend->requesterUser;

                        @endphp

                        <div class="friends-card">


                            <div class="friends-card__top">

                                <div class="nexora-rating__friends">

                                    <svg width="9" height="10" viewBox="0 0 9 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.501515 5.99974C0.406933 6.00006 0.314202 5.97354 0.234093 5.92325C0.153985 5.87296 0.089788 5.80097 0.0489615 5.71564C0.00813498 5.63032 -0.00764548 5.53515 0.00345355 5.44121C0.0145526 5.34727 0.0520755 5.25841 0.111663 5.18495L5.05979 0.0862798C5.0969 0.0434316 5.14748 0.0144766 5.20322 0.00416749C5.25896 -0.00614162 5.31655 0.00280769 5.36654 0.0295465C5.41652 0.0562853 5.45593 0.0992248 5.4783 0.151317C5.50066 0.203409 5.50466 0.261558 5.48962 0.31622L4.52999 3.32544C4.50169 3.40118 4.49219 3.48266 4.50229 3.56288C4.5124 3.6431 4.54181 3.71967 4.58801 3.78603C4.63421 3.85239 4.69581 3.90654 4.76754 3.94386C4.83926 3.98117 4.91896 4.00052 4.99981 4.00026H8.49848C8.59307 3.99994 8.6858 4.02646 8.76591 4.07675C8.84601 4.12704 8.91021 4.19903 8.95104 4.28436C8.99187 4.36969 9.00765 4.46485 8.99655 4.55879C8.98545 4.65273 8.94792 4.74159 8.88834 4.81505L3.94021 9.91372C3.9031 9.95657 3.85252 9.98552 3.79678 9.99583C3.74104 10.0061 3.68345 9.99719 3.63346 9.97045C3.58348 9.94371 3.54407 9.90077 3.5217 9.84868C3.49934 9.79659 3.49534 9.73844 3.51038 9.68378L4.47001 6.67456C4.49831 6.59882 4.50781 6.51734 4.49771 6.43712C4.4876 6.3569 4.45819 6.28033 4.41199 6.21397C4.36579 6.14762 4.30419 6.09346 4.23246 6.05614C4.16074 6.01883 4.08104 5.99948 4.00019 5.99974H0.501515Z" fill="#8B5CF6" />
                                    </svg>

                                    <span>{{ $friendUser->nexora_rating }}</span>
                                </div>

                                <div class="current-status__friend">
                                    <div class="dot-status"></div>
                                    <span class="text-status">MATCH</span>
                                </div>

                            </div>

                            <div class="friends-card__inner">

                                <a href="{{route('profile.show', $friendUser->id)}}" class="friends-card__avatar">
                                    <img src="{{ $friendUser->avatar }}" alt="">
                                </a>

                                <div class="friend-card__info">
                                    <a href="{{route('profile.show', $friendUser->id)}}" class="friends-nickname">{{ $friendUser->nickname }}</a>
                                    <div class="friends-server">EU WEST</div>
                                    <div class="friends-activity">Last seen 1d ago</div>

                                    <button CLASS="friend-invite__party">
                                        ADD PARTY
                                    </button>


                                </div>



                            </div>

                            <div class="friends-hl"></div>

                            <form method="POST" action="{{ route('friends.destroy', $friend->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="unfriend">Unfriend</button>
                            </form>

                        </div>
                    @endforeach
                @endif

                    <div class="friends-empty hidden" data-empty="search">
                        <h3>No users found</h3>
                    </div>
            </div>
        </section>

        <section class="friends-cards" id="global_tab">
            <div class="friends-cards__inner">


                @if($usersAll->isEmpty())
                    <div class="friends-empty" data-empty="base">
                        <h3>No users yet</h3>
                    </div>
                @else
                    @foreach($usersAll as $user)

                        @php
                            $friendship = $friendshipsMap[$user->id] ?? null;


                        @endphp


                        <div class="friends-card">


                            <div class="friends-card__top">

                                <div class="nexora-rating__friends">

                                    <svg width="9" height="10" viewBox="0 0 9 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.501515 5.99974C0.406933 6.00006 0.314202 5.97354 0.234093 5.92325C0.153985 5.87296 0.089788 5.80097 0.0489615 5.71564C0.00813498 5.63032 -0.00764548 5.53515 0.00345355 5.44121C0.0145526 5.34727 0.0520755 5.25841 0.111663 5.18495L5.05979 0.0862798C5.0969 0.0434316 5.14748 0.0144766 5.20322 0.00416749C5.25896 -0.00614162 5.31655 0.00280769 5.36654 0.0295465C5.41652 0.0562853 5.45593 0.0992248 5.4783 0.151317C5.50066 0.203409 5.50466 0.261558 5.48962 0.31622L4.52999 3.32544C4.50169 3.40118 4.49219 3.48266 4.50229 3.56288C4.5124 3.6431 4.54181 3.71967 4.58801 3.78603C4.63421 3.85239 4.69581 3.90654 4.76754 3.94386C4.83926 3.98117 4.91896 4.00052 4.99981 4.00026H8.49848C8.59307 3.99994 8.6858 4.02646 8.76591 4.07675C8.84601 4.12704 8.91021 4.19903 8.95104 4.28436C8.99187 4.36969 9.00765 4.46485 8.99655 4.55879C8.98545 4.65273 8.94792 4.74159 8.88834 4.81505L3.94021 9.91372C3.9031 9.95657 3.85252 9.98552 3.79678 9.99583C3.74104 10.0061 3.68345 9.99719 3.63346 9.97045C3.58348 9.94371 3.54407 9.90077 3.5217 9.84868C3.49934 9.79659 3.49534 9.73844 3.51038 9.68378L4.47001 6.67456C4.49831 6.59882 4.50781 6.51734 4.49771 6.43712C4.4876 6.3569 4.45819 6.28033 4.41199 6.21397C4.36579 6.14762 4.30419 6.09346 4.23246 6.05614C4.16074 6.01883 4.08104 5.99948 4.00019 5.99974H0.501515Z" fill="#8B5CF6" />
                                    </svg>

                                    <span>{{ $user->nexora_rating }}</span>
                                </div>

                                <div class="current-status__friend">
                                    <div class="dot-status"></div>
                                    <span class="text-status">MATCH</span>
                                </div>

                            </div>

                            <div class="friends-card__inner">

                                <a href="{{route('profile.show', $user->id)}}" class="friends-card__avatar">
                                    <img src="{{ $user->avatar }}" alt="">
                                </a>

                                <div class="friend-card__info">
                                    <a href="{{route('profile.show', $user->id)}}" class="friends-nickname">{{ $user->nickname }}</a>
                                    <div class="friends-server">EU WEST</div>
                                    <div class="friends-activity">Last seen 1d ago</div>

                                    <button CLASS="friend-invite__party">
                                        ADD PARTY
                                    </button>


                                </div>



                            </div>

                            <div class="friends-hl"></div>

                            @if ( !$friendship)
                                <form method="POST" action="{{ route('friends.store', $user->id) }}">
                                    @csrf
                                    <button type="submit" class="addfriend_btn">Add Friend</button>
                                </form>
                            @elseif(
                                $friendship->status === 'pending'
                                &&
                                $friendship->requester_id === auth()->id()
                            )
                                <form method="POST" action="{{ route('friends.destroy', $friendship->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cancel_btn">Cancel</button>
                                </form>
                            @elseif(
                                $friendship->status === 'pending'
                                &&
                                $friendship->addressee_id === auth()->id()
                            )
                                <div class="accept_decline--block">
                                    <form method="POST" action="{{ route('friends.accept', $friendship->id) }}">
                                        @csrf
                                        <button type="submit" class="accept_btn">Accept</button>
                                    </form>

                                    <form method="POST" class="decline_form" style="width: 39px;" action="{{ route('friends.decline', $friendship->id) }}">
                                        @csrf
                                        <button type="submit" class="decline_btn">
                                            x
                                        </button>
                                    </form>
                                </div>

                            @elseif($friendship->status === 'accepted')

                                <form method="POST" action="{{ route('friends.destroy', $friendship->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="unfriend">Unfriend</button>
                                </form>

                            @endif
                        </div>
                    @endforeach
                @endif
                    <div class="friends-empty hidden" data-empty="search">
                        <h3>No users found</h3>
                    </div>

            </div>
        </section>

        <section class="friends-cards" id="requests_tab">
            <div class="friends-cards__inner">
                @if($incomingRequests->isEmpty())
                    <div class="friends-empty" data-empty="base">
                        <h3>No friends yet</h3>
                    </div>

                @else
                    @foreach($incomingRequests as $request)
                        @php
                            $user = $request->requesterUser;
                        @endphp

                        <div class="friends-card">


                            <div class="friends-card__top">

                                <div class="nexora-rating__friends">

                                    <svg width="9" height="10" viewBox="0 0 9 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.501515 5.99974C0.406933 6.00006 0.314202 5.97354 0.234093 5.92325C0.153985 5.87296 0.089788 5.80097 0.0489615 5.71564C0.00813498 5.63032 -0.00764548 5.53515 0.00345355 5.44121C0.0145526 5.34727 0.0520755 5.25841 0.111663 5.18495L5.05979 0.0862798C5.0969 0.0434316 5.14748 0.0144766 5.20322 0.00416749C5.25896 -0.00614162 5.31655 0.00280769 5.36654 0.0295465C5.41652 0.0562853 5.45593 0.0992248 5.4783 0.151317C5.50066 0.203409 5.50466 0.261558 5.48962 0.31622L4.52999 3.32544C4.50169 3.40118 4.49219 3.48266 4.50229 3.56288C4.5124 3.6431 4.54181 3.71967 4.58801 3.78603C4.63421 3.85239 4.69581 3.90654 4.76754 3.94386C4.83926 3.98117 4.91896 4.00052 4.99981 4.00026H8.49848C8.59307 3.99994 8.6858 4.02646 8.76591 4.07675C8.84601 4.12704 8.91021 4.19903 8.95104 4.28436C8.99187 4.36969 9.00765 4.46485 8.99655 4.55879C8.98545 4.65273 8.94792 4.74159 8.88834 4.81505L3.94021 9.91372C3.9031 9.95657 3.85252 9.98552 3.79678 9.99583C3.74104 10.0061 3.68345 9.99719 3.63346 9.97045C3.58348 9.94371 3.54407 9.90077 3.5217 9.84868C3.49934 9.79659 3.49534 9.73844 3.51038 9.68378L4.47001 6.67456C4.49831 6.59882 4.50781 6.51734 4.49771 6.43712C4.4876 6.3569 4.45819 6.28033 4.41199 6.21397C4.36579 6.14762 4.30419 6.09346 4.23246 6.05614C4.16074 6.01883 4.08104 5.99948 4.00019 5.99974H0.501515Z" fill="#8B5CF6" />
                                    </svg>

                                    <span>{{ $user->nexora_rating }}</span>
                                </div>

                                <div class="current-status__friend">
                                    <div class="dot-status"></div>
                                    <span class="text-status">MATCH</span>
                                </div>

                            </div>

                            <div class="friends-card__inner">

                                <a href="{{route('profile.show', $user->id)}}" class="friends-card__avatar">
                                    <img src="{{ $user->avatar }}" alt="">
                                </a>

                                <div class="friend-card__info">
                                    <a href="{{route('profile.show', $user->id)}}" class="friends-nickname">{{ $user->nickname }}</a>
                                    <div class="friends-server">EU WEST</div>
                                    <div class="friends-activity">Last seen 1d ago</div>

                                    <button CLASS="friend-invite__party">
                                        ADD PARTY
                                    </button>


                                </div>



                            </div>

                            <div class="friends-hl"></div>


                                <div class="accept_decline--block">
                                    <form method="POST" action="{{ route('friends.accept', $request->id) }}">
                                        @csrf
                                        <button type="submit" class="accept_btn">Accept</button>
                                    </form>

                                    <form method="POST" class="decline_form" style="width: 39px;" action="{{ route('friends.decline', $request->id) }}">
                                        @csrf
                                        <button type="submit" class="decline_btn">
                                            x
                                        </button>
                                    </form>
                                </div>


                        </div>
                    @endforeach
                @endif


                    <div class="friends-empty hidden" data-empty="search">
                        <h3>No users found</h3>
                    </div>
            </div>
        </section>





    </main>


@endsection
