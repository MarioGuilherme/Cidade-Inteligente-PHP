$(document).ready(() => {
    const typeWrite = element => {
        const textoArray = element.innerHTML.split("");
        element.innerHTML = " ";
        textoArray.forEach((letra, i) => {
            setTimeout(() => element.innerHTML += letra, 75 * i);
        });
    }
    typeWrite($(".title")[0]);
});