@php
$keywords = ['auto', 'break', 'case', 'char', 'const', 'continue', 'default', 'do', 'double', 'else', 'enum', 'extern', 'float', 'for', 'goto', 'if', 'int', 'long', 'register', 'return', 'short', 'signed', 'sizeof', 'static', 'struct', 'switch', 'typedef', 'union', 'unsigned', 'void', 'volatile', 'while','False', 'None', 'True', 'and', 'as', 'assert', 'break', 'class', 'continue', 'def', 'del', 'elif', 'else', 'except', 'finally', 'for', 'from', 'global', 'if', 'import', 'in', 'is', 'lambda', 'nonlocal', 'not', 'or', 'pass', 'raise', 'return', 'try', 'while', 'with', 'yield'];


$codes_lines = explode("\n",$code);
// dump($codes_lines);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Craft | Mahi</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
  body {
  background: #002b36;
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
  color: #839496;
  background-color: #002b36;
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
  color: #586e75;
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
.pln{color:#000}@media screen{.str{color:#080}.kwd{color:#008}.com{color:#800}.typ{color:#606}.lit{color:#066}.pun,.opn,.clo{color:#660}.tag{color:#008}.atn{color:#606}.atv{color:#080}.dec,.var{color:#606}.fun{color:red}}@media print,projection{.str{color:#060}.kwd{color:#006;font-weight:bold}.com{color:#600;font-style:italic}.typ{color:#404;font-weight:bold}.lit{color:#044}.pun,.opn,.clo{color:#440}.tag{color:#006;font-weight:bold}.atn{color:#404}.atv{color:#060}}pre.prettyprint{padding:2px;}ol.linenums{margin-top:0;margin-bottom:0}li.L0,li.L1,li.L2,li.L3,li.L5,li.L6,li.L7,li.L8,li.L1,li.L3,li.L5,li.L7,li.L9{background:#002b36}

    </style>
</head>
<body>
    {{-- All code showing here --}}
    <pre class="prettyprint linenums prettyprinted">
       <ol class="linenums">
        @php
            $lloop=0;
        @endphp
        @foreach ($codes_lines as $id=>$code)

          @php
            $words = explode(' ',$code);
           $lloop =  $lloop==9?0:$lloop+1;
          @endphp
        <li  class="L{{$lloop}}"> 
            
            <span class="kw">{{$code}}</span>
          
        </li>

        @endforeach
        
       
        
       </ol>
        
    </pre>
 
</body>
</html>
