//state.js
export const state = {
    meId: null,

    matchId: null,

    roles: {
        primary: null,
        secondary: null,
    },

    friends: [],


    party: null,
    partyInvites: [],

    matchPlayers: [],


    mode: 'all_pick', //default
    // all_pick || ranked
    server: 'us_west', //default
    // us_west || eu_west || stockholm

    status: 'idle',
    // idle | searching | found | accepted | started
}

state.meId = window.__ME_ID__;


console.log('state loaded', state)
