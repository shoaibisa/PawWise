<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Craft | Mahi</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body {
  background: #7a5dfc;
  padding:    0;
  margin:     0;
}

textarea {
  width:       90%;
  height:      90%;
  overflow:    auto;
  border:      0;
  padding:     0;
  outline:     none;
  resize:      none;
  font-family: monospace;
  font-size:   16px;
  position:    absolute; 
  top:         2em;
  right:       2em;
  bottom:      2em;
  left:        4em;
}
textarea:placeholder{
  color: #ffffff;
}

@-moz-document url-prefix() {
  textarea {
    width:     90%;
    height:    90%;
  }
}

pre {
  font-family: monospace;
  font-size:   16px;
  position:    absolute;
  top:         1em;
  right:       2em;
  bottom:      2em;
  left:        1.5em;
}

/*
::-webkit-scrollbar {
  opacity: 0
}
*/
.prettyprint {
  color: #ffffff;
  background-color: #7a5dfc;
}


.prettyprint .pln {
  color: inherit;
}

.prettyprint .str,
.prettyprint .lit,
.prettyprint .atv {
  color: #2aa198;
}

.prettyprint .kwd {
  color: #268bd2;
}

.prettyprint .com,
.prettyprint .dec {
  color: #380758;
  font-style: italic;
}

.prettyprint .typ {
  color: #b58900;
}

.prettyprint .pun {
  color: inherit;
}

.prettyprint .opn {
  color: inherit;
}

.prettyprint .clo {
  color: inherit;
}

.prettyprint .tag {
  color: #268bd2;
  font-weight: bold;
}

.prettyprint .atn {
  color: inherit;
}


    </style>
</head>
<body>
    <textarea class="prettyprint" name="code" id="editor" placeholder="[ paste text  -  ctrl+s to save ]" spellcheck="false"></textarea>

    <script>
      window.addEventListener('keydown', function(event) {
          // Capture Ctrl+S event
          if ((event.ctrlKey || event.metaKey) && event.key === 's') {
              event.preventDefault(); // Prevent browser's default save action
  
              // Get content from textarea
              var content = document.getElementById('editor').value;
  
              // Send content to backend
              axios.post('{{ route("save-content") }}', {
                  code: content
              })
              .then(function (response) {
                  // Redirect to the page with the saved content's ID
                  if(response.data.isError){
                    return alert('Error Occured');
                  }
                  window.location.href = '/code/' + response.data.id;
              })
              .catch(function (error) {
                  console.error(error);
                  alert('Error occurred while saving content.');
              });
          }
      });
  </script>
  
</body>
</html>
