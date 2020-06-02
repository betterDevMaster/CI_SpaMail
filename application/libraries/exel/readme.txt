Lecture d'un fichier excel ---------------------------
Url     : http://codes-sources.commentcamarche.net/source/41045-lecture-d-un-fichier-excelAuteur  : cs_cacoucatatoniqueDate    : 09/08/2013
Licence :
=========

Ce document intitulé « Lecture d'un fichier excel  » issu de CommentCaMarche
(codes-sources.commentcamarche.net) est mis à disposition sous les termes de
la licence Creative Commons. Vous pouvez copier, modifier des copies de cette
source, dans les conditions fixées par la licence, tant que cette note
apparaît clairement.

Description :
=============

bonjour &agrave; tous, j'ai cherch&eacute; pendant quelque temps un code pour li
re les fichiers excels afin de mettre &agrave; jour ma base de donn&eacute;e, de
 mani&eacute;re automatique.
<br />Et un bon jour je suis tomb&eacute; dessus p
ar azard sur internet. La classe n'est donc pas de moi par contre l'exemple qui 
tous simple,lui , est de ma conception.
<br /><a name='source-exemple'></a><h2>
 Source / Exemple : </h2>
<br /><pre class='code' data-mode='basic'>
&lt;?php


require_once 'Excel/reader.php';

// ExcelFile($filename, $encoding);
$da
ta = new Spreadsheet_Excel_Reader();

// Set output Encoding.
$data-&gt;setOu
tputEncoding('CP1251');

/***

<ul><li> if you want you can change 'iconv' t
o mb_convert_encoding:
</li><li> $data-&gt;setUTFEncoder('mb');</li></ul>
*


<ul><li><ul><li>/</li></ul></li></ul>

/***

<ul><li> By default rows &amp;
 cols indeces start with 1
</li><li> For change initial index use:
</li><li> $
data-&gt;setRowColOffset(0);</li></ul>
*

<ul><li><ul><li>/</li></ul></li></u
l>

/***

<ul><li>  Some function for formatting output.
</li><li> $data-&g
t;setDefaultFormat('%.2f');
</li><li> setDefaultFormat - set format for columns
 with unknown formatting</li></ul>
*

<ul><li> $data-&gt;setColumnFormat(4, '
%.3f');
</li><li> setColumnFormat - set format for column (apply only to number
 fields)</li></ul>
*

<ul><li><ul><li>/</li></ul></li></ul>

$data-&gt;read
('toto.xls');

/*

 $data-&gt;sheets[0]['numRows'] - count rows
 $data-&gt;
sheets[0]['numCols'] - count columns
 $data-&gt;sheets[0]['cells'][$i][$j] - da
ta from $i-row $j-column

 $data-&gt;sheets[0]['cellsInfo'][$i][$j] - extended
 info about cell

    $data-&gt;sheets[0]['cellsInfo'][$i][$j]['type'] = &quot
;date&quot; | &quot;number&quot; | &quot;unknown&quot;
        if 'type' == &qu
ot;unknown&quot; - use 'raw' value, because  cell contain value with format '0.0
0';
    $data-&gt;sheets[0]['cellsInfo'][$i][$j]['raw'] = value if cell without
 format
    $data-&gt;sheets[0]['cellsInfo'][$i][$j]['colspan']
    $data-&gt;
sheets[0]['cellsInfo'][$i][$j]['rowspan']

<ul><li>/</li></ul>

error_report
ing(E_ALL ^ E_NOTICE);
/*
for ($i = 1; $i &lt;= $data-&gt;sheets[0]['numRows']
; $i++) {
	for ($j = 1; $j &lt;= $data-&gt;sheets[0]['numCols']; $j++) {
		ech
o &quot;&quot;.$data-&gt;sheets[0]['cells'][$i][$j].&quot;&lt;br&gt;&quot;;
	}

	echo &quot;\n&quot;;

}

<ul><li>/</li></ul>

echo &quot;&quot;.$data-&g
t;sheets[0]['cells'][1][1].&quot;&lt;br&gt;&quot;;
echo &quot;&quot;.$data-&gt;
sheets[0]['cells'][1][2].&quot;&lt;br&gt;&quot;;

//print_r($data);
//print_r
($data-&gt;formatRecords);
?&gt;
</pre>
<br /><a name='conclusion'></a><h2> C
onclusion : </h2>
<br />voici le lien du sie ou je l'ai trouv&eacute;:
<br />
<a href='http://freshmeat.net/projects/phpexcelreader/' target='_blank'>http://f
reshmeat.net/projects/phpexcelreader/</a>
<br />enfin bon voila, j'ai trouv&eac
ute; cela assez interessant, c'est pour cela que je le propose.
