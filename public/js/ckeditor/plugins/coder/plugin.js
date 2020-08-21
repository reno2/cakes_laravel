CKEDITOR.plugins.add( 'coder', {
    icons: 'coder',
    init: function( editor ) {
        editor.addCommand( 'insertCoder', {
            exec: function( insertCoder ) {
                let regex = /(<code class="inner">)(.*?)(<\/code>)/g;
                let data = editor.getSelection().getStartElement().getOuterHtml();
                let selected = editor.getSelectedHtml(true)

                 if(selected) {
                     //console.log(selected)
                     let res = selected.match(regex)
                     if(res != null && res.length){
                         let result = '';
                         res.forEach((el)=>{
                             result += el.replace(regex, '$2')
                         });
                         editor.insertHtml(result);
                     }else{
                         editor.insertHtml(`<code class="inner">${selected}</code>`);
                     }


                    // this.func(selected, editor)

                //     console.log(selected)
                //     if (reg.test(selected)) {
                //         console.log('true')
                //         let res = data.replace(reg, '$3')
                //         editor.insertHtml(res);
                //
                //     } else {
                //         console.log('false')
                //         editor.insertHtml('<code class="inner">' + editor.getSelection().getSelectedText() + '</code>');
                //     }
                }
                //editor.insertHtml( '<code class="inner">' + editor.getSelection().getSelectedText() + '</code>' );
                //console.log(editor.getSelection().getStartElement().getOuterHtml());
            }
        });
        editor.ui.addButton( 'coder', {
            label: 'Insert Code',
            command: 'insertCoder',
            toolbar: 'insert'
        });
    },
    func: function(str, editor){
        let regex = /(<code class="inner">)(.*?)(<\/code>)/g;
        let res = str.match(regex)
        let result = ''
        if(res != null && res.length){
            res.forEach((el)=>{
                result += el.replace(regex, '$2')
            })
            return result
        }else{
            editor.insertHtml(`<code class="inner">${str}</code>`);
        }
        return result
    }
});