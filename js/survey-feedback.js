document.addEventListener("DOMContentLoaded",(function(){var e=document.querySelector(".survey-intro"),n=document.querySelector(".survey-action"),t=document.getElementById("survey-yes"),c=document.getElementById("survey-no"),d=document.querySelector(".survey-yes"),s=document.querySelector(".survey-no"),o=function(t,c,d,s){e&&e.classList.add("d-none"),d&&d.classList.remove("d-none"),s&&s.classList.add("d-none"),t&&t.classList.add("clicked"),c&&c.classList.remove("clicked"),n&&n.classList.remove("d-none")};t.addEventListener("click",(function(){o(t,c,d,s)})),c.addEventListener("click",(function(){o(c,t,s,d)}))}));