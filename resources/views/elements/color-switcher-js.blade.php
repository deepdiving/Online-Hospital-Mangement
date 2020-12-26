<script>
// Theme color settings
$(document).ready(function(){
    $("*[data-theme]").click(function(e){
      e.preventDefault();
        var currentStyle = $(this).attr('data-theme');
        store('theme', currentStyle);
        $('#theme').attr({href: '{{asset("material")}}/css/colors/'+currentStyle+'.css'})
    });

    var currentTheme = get('theme');
    if(currentTheme)
    {
      $('#theme').attr({href: '{{asset("material")}}/css/colors/'+currentTheme+'.css'});
    }
    // color selector
    $('#themecolors').on('click', 'a', function(){
        $('#themecolors li a').removeClass('working');
        $(this).addClass('working')
      });

});

function store(name, val) {
    $.ajax({
        type: "GET",
        url: "{{url('theme-switcher')}}/"+val,
        data: "data",
        dataType: "text",
        beforeSend: function(){},
        success: function (response) {
            console.log(response);
        }
    });
}

 function get(name) {}

$(document).ready(function(){
    $("*[data-theme]").click(function(e){
      e.preventDefault();
        var currentStyle = $(this).attr('data-theme');
        store('theme', currentStyle);
        $('#theme').attr({href: '{{asset("material")}}/css/colors/'+currentStyle+'.css'})
    });
    var currentTheme = get('theme');
    if(currentTheme){
      $('#theme').attr({href: '{{asset("material")}}/css/colors/'+currentTheme+'.css'});
    }
    // color selector
    $('#themecolors').on('click', 'a', function(){
        $('#themecolors li a').removeClass('working');
        $(this).addClass('working')
    });
});

</script>