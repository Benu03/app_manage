function close_modal(){
    // $(".modal-backdrop").remove();
    // $('body').removeClass('modal-open');
    // $('#modal').removeClass('show');
    // $('#modal').removeClass('fade');
    // $('body').css('padding-right', '');
    // $('#modal').css('padding-right', '');
    // $("#modal").hide();
    // $("#modal").removeClass("in");
    $(this).parents('.modal').modal('hide');
    
}
    // Search Menu
        $("#close_search_menu").hide();
        $("#searchInputt").on("keyup", function () {

        $("li.menu-item").addClass('menu-open');
        $("li.menu-item").addClass('menu-is-opening');
        
        if (this.value.length > 0) {   
            $("li.menu-item").hide().filter(function () {
            return $(this).text().toLowerCase().indexOf($("#searchInputt").val().toLowerCase()) != -1;
          }).show(); 
          $("#close_search_menu").show();
        }  
        else { 
            $("li.menu-item").show();
            $("li.menu-item").removeClass('menu-open');
        $("li.menu-item").removeClass('menu-is-opening');
        $("#close_search_menu").hide();
        }
        }); 
        
        $("#close_search_menu").on("click", function () {
            $("#close_search_menu").hide();
            $("li.menu-item").removeClass('menu-open');
            $("li.menu-item").removeClass('menu-is-opening');
            $("li.menu-item").show();
            document.getElementById("searchInputt").value = "";
        }); 
        function addTextUpload(){
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    }
        // var mylist = $('#listItemChecklist');
       
        // var listitems = mylist.children('li').get();
        // console.log(listitems)
        // listitems.sort(function(a, b) {
        //    return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
        // })
        // $.each(listitems, function(idx, itm) { mylist.append(itm); });$( document ).ready(function() {
 
      
     