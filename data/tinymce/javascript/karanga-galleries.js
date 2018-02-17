(function()
{ 


  tinymce.create('tinymce.plugins.karanga_mce_plugin',
  {    
    init : function(ed, url) 
    {
      ed.addCommand('mcekaranga_mce_plugin', function() 
      {
        ed.windowManager.open(
        {
          file: url+'/../../../karanga-v2.php?page=gallery_template_tinymce',
          width : 650 + ed.getLang('styleeditor_mce_plugin.delta_width', 0),
          height : 550 + ed.getLang('styleeditor_mce_plugin.delta_height', 0),
          inline : 1
        }, 
        {
          plugin_url : url,
          some_custom_arg : 'custom arg'// Custom argument
        });
      });


      ed.addButton('karanga_mce_plugin', 
      {
        title : 'Karanga',
        text: 'Karanga',
        cmd : 'mcekaranga_mce_plugin'
      });
    },
    getInfo : function() 
    {
      return {
        longname : 'TinyMCE Plugin for Wordpress Karanga Plugin',
        author : 'Yasin Yazici',
        authorurl : 'http://www.di-unternehmer.com',
        version : "1.0"
      };
    }
  });
  
  tinymce.PluginManager.add('karanga_mce_plugin', tinymce.plugins.karanga_mce_plugin);
})();
