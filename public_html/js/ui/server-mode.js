import {state} from "../core/state.js";

let serverUI = document.querySelector('.server-search__text');
let gamemodeUI = document.querySelector('.gamemode-search__text');

export function serverAndGamemodeUI(){
    if (state.status !== 'searching') return;

    if (state.mode === 'all_pick'){
        gamemodeUI.textContent = 'RANKED ALL PICK'
    } else {
        gamemodeUI.textContent = 'RANKED TURBO'
    }

    if (state.server === 'us_west'){
        serverUI.textContent = 'US West'
    } else if(state.server === 'eu_west'){
        serverUI.textContent = 'EU West'
    } else{
        serverUI.textContent = 'Stockholm'
    }
}
