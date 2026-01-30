
import { renderUI } from '../ui/render-ui.js';
import {state} from "./state.js";

export function setStatus(status) {
    if (state.status === status) return;

    state.status = status;
    renderUI();
}
