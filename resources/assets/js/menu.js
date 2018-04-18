(function(){
  $(document).ready(function () {
       /******************* 自定义菜单模块 *************************/
       
       //删除
       $('.delete').on('click', function () {
           $(this).parents('tr').remove();
       });

  })
}())