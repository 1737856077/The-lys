(function() {
  $(function() {
    var $preview, editor, mobileToolbar, toolbar;
    Simditor.locale  = 'zh-CN';
    toolbar			 = ['title', 'bold', 'italic', 'underline', 'strikethrough', 'fontScale', 'color', 'image', 'hr',  'indent', 'outdent', 'alignment'];
    editor = new Simditor({
      textarea: $('#txt-content'),
      placeholder: '这里输入文字...',
      toolbar: toolbar,
			imageButton:'upload',
      //pasteImage: true,
      //defaultImage: 'assets/images/image.png',
      upload: {
        url: '/index.php?m=user&c=shopfile'
      }
    });
    $preview = $('#preview');
    if ($preview.length > 0) {
      return editor.on('valuechanged', function(e) {
        return $preview.html(editor.getValue());
      });
    }
  });

}).call(this);
