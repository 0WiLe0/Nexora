import { state } from '../core/state.js';
import {prepareAcceptGroup} from "../accept-group/accept-group.state.js";
import {acceptGroupRender} from "../accept-group/accept-group.render.js";

const acceptBlock = document.querySelector('.accept-play__block');
const acceptBtn = document.querySelector('.accept-btn');
let yourGroupAccept = document.querySelector('.your-group__accept');
let personalAccept = document.querySelector('.personal-accept');

export function renderAccept() {
    if (state.status === 'found') {
        acceptBlock.classList.remove('hidden');
        acceptBtn.disabled = false;
        return;
    }


    acceptBlock.classList.add('hidden');
    acceptBtn.disabled = true;
}


export function resetAcceptUI() {
    acceptBlock.classList.remove('accepted');
    acceptBlock.classList.add('hidden');

    acceptBtn.disabled = false;

    personalAccept.classList.remove('ready');
}

export function updateAcceptGroup() {
    const players = prepareAcceptGroup();
    acceptGroupRender(players);
}
