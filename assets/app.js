/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import './styles/custom.scss';

import { Tooltip, Toast, Popover } from 'bootstrap';

// start the Stimulus application
import './bootstrap';

//Suppression des element

document.querySelectorAll('[data-delete]').forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault()
        fetch(a.getAttribute('href'), {
            method: 'DELETE',
            header: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({'_token': a.dataset.token})
        }).then(Response => Response.json())
        .then(data => {
            if(data.success){
                a.parentNode.parentNode.removeChild(a.parentNode)
            } else {
                alert(data.error)
            }
        })
        .catch(e => alert(e))
    })
})