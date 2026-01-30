import { state } from '../core/state.js';

const modeBtn = document.querySelector('.arrow_select_mode');
const serverBtn = document.querySelector('.arrow_select_server');

let modeBlock = document.querySelector('.js-mode-list');
let serverBlock = document.querySelector('.js-server-list');

let modeText = document.querySelector('.js-mode-value');
let serverText = document.querySelector('.js-server-value');

let dropdownBlocks = document.querySelectorAll('.dropdown_item');


modeBtn.addEventListener('click', () => {
    if (modeBlock.classList.contains('hidden')){
        modeBlock.classList.remove('hidden');
        modeBtn.style.transform = 'rotate(-180deg)';

        hiddenDropDown(serverBlock, serverBtn);

        return;
    } else {
        modeBlock.classList.add('hidden');
        modeBtn.style.transform = 'rotate(0)';
        return;
    }
});

serverBtn.addEventListener('click', () => {
    if ( serverBlock.classList.contains('hidden')){
        serverBlock.classList.remove('hidden');
        serverBtn.style.transform = 'rotate(-180deg)';

        hiddenDropDown(modeBlock, modeBtn);
        return;
    } else {
        serverBlock.classList.add('hidden');
        serverBtn.style.transform = 'rotate(0)';
        return;
    }
});

function hiddenDropDown(block, btn){
    block.classList.add('hidden');
    btn.style.transform = 'rotate(0)';
}

dropdownBlocks.forEach(dropdownBlock => {
    dropdownBlock.addEventListener('click', () => {
        if (dropdownBlock.dataset.mode){
            state.mode  = dropdownBlock.dataset.mode;

            if (state.mode === 'all_pick'){
                modeText.textContent = 'RANKED ALL PICK'
            } else {
                modeText.textContent = 'RANKED TURBO'
            }

            hiddenDropDown(modeBlock, modeBtn);
        } else if (dropdownBlock.dataset.server) {
            state.server = dropdownBlock.dataset.server;

            if (state.server === 'us_west'){
                serverText.textContent = 'US West'
            } else if(state.server === 'eu_west'){
                serverText.textContent = 'EU West'
            } else{
                serverText.textContent = 'Stockholm'
            }


            hiddenDropDown(serverBlock, serverBtn);
        }

        console.log(state.mode, state.server);
    });
});
