(()=>{function e(e){return function(e){if(Array.isArray(e))return t(e)}(e)||function(e){if("undefined"!=typeof Symbol&&null!=e[Symbol.iterator]||null!=e["@@iterator"])return Array.from(e)}(e)||function(e,n){if(e){if("string"==typeof e)return t(e,n);var a={}.toString.call(e).slice(8,-1);return"Object"===a&&e.constructor&&(a=e.constructor.name),"Map"===a||"Set"===a?Array.from(e):"Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a)?t(e,n):void 0}}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function t(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,a=Array(t);n<t;n++)a[n]=e[n];return a}document.addEventListener("DOMContentLoaded",(function(){var t=document.querySelector(".cat-tax-select"),n=t.querySelector("select"),a=Array.from(n.options),r=document.createElement("div");r.className="cat-tax-selected",r.innerHTML='\n\t\t<span class="cat-tax-placeholder">Select Multiple</span>\n\t\t<div class="cat-tax-selected-items"></div>\n\t\t<span class="arrow">&#9662;</span>\n\t';var o=document.createElement("ul");o.className="cat-tax-options",a.forEach((function(e){if(e.value){var t=document.createElement("li");t.dataset.value=e.value,t.textContent=e.textContent,o.appendChild(t)}})),t.appendChild(r),t.appendChild(o);var c=r.querySelector(".cat-tax-selected-items"),i=r.querySelector(".cat-tax-placeholder");r.addEventListener("click",(function(){t.classList.toggle("open")})),o.addEventListener("click",(function(t){if("LI"===t.target.tagName){var a=t.target.dataset.value,r=t.target.textContent;if(!c.querySelector('[data-value="'.concat(a,'"]'))){var o=document.createElement("span");o.className="selected-item",o.dataset.value=a,o.innerHTML="".concat(r,' <span class="remove">&times;</span>'),c.appendChild(o);var l=e(n.options).find((function(e){return e.value===a}));l&&(l.selected=!0),i.style.display="none"}}})),c.addEventListener("click",(function(t){var a=t.target.closest(".selected-item");if(a){var r=a.dataset.value;a.remove();var o=e(n.options).find((function(e){return e.value===r}));o&&(o.selected=!1),0===c.children.length&&(i.style.display="inline")}})),document.addEventListener("click",(function(e){t.contains(e.target)||t.classList.remove("open")}))})),document.addEventListener("DOMContentLoaded",(function(){var e=document.querySelector("#ubc7-unit-menu"),t=document.querySelector(".vpfo .archive-filters");if(e&&t){var n=function(){window.innerWidth>=980?e.classList.contains("stick-to-top")&&(t.style.top="61px"):t.style.top=""};n(),setTimeout(n,100),window.addEventListener("resize",n)}}))})();