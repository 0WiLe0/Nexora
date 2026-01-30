//canceled.js

import { state } from '../core/state.js';

const searchBlock = document.querySelector('.search-play__block');
const canceledBtn = document.querySelector('.cancel-search__btn');
let findBtn = document.querySelector('.ranked__find');

export function renderCanceled() {
    if (state.status === 'searching') {
        canceledBtn.disabled = false;
        findBtn.disabled = true;
    } else {
        canceledBtn.disabled = true;
        findBtn.disabled = false;
    }
}



