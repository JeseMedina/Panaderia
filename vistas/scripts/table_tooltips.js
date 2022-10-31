$(document).ready(()=>{
    table_buttons = $(".dt-button");
    table_buttons.each(x=>{
        table_buttons[x].dataset.toggle="tooltip";
        table_buttons[x].dataset.placement="right"
        title = "Exportar en " + table_buttons[x].children[0].innerHTML
        table_buttons[x].setAttribute("title", title)
        $(table_buttons[x]).tooltip()
    })
})