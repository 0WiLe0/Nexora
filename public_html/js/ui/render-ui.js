import { renderSearch } from './search.js';
import { renderAccept } from './accept.js';
import { renderCanceled } from './canceled.js';
import { serverAndGamemodeUI } from "./server-mode.js";
import {renderSelectRoles} from "./render-select-roles.js";


export function renderUI() {
    renderSearch();
    renderAccept();
    renderCanceled();
    serverAndGamemodeUI();
    renderSelectRoles();
}
