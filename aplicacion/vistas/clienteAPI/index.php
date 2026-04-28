<?php
    
    $tabla=new CGrid($cab,$fil);

    echo  $tabla->dibujate();
 ?>
 <style>
    div.tabla table.tabla {
    width: 90%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    font-size: 14px;
    padding-left: 20px;
}
div.tabla {
    padding-left: 30px;
}
div.tabla table.tabla th {
    background: #f97316;
    color: white;
    padding: 12px;
    text-align: left;
    font-weight: 600;
}

div.tabla table.tabla td {
    padding: 10px 12px;
    border-bottom: 1px solid #eee;
}

div.tabla table.tabla tr:hover {
    background: #fff7ed;
    transition: 0.2s;
}

div.tabla table.tabla tr.par {
    background: #fafafa;
}

div.tabla table.tabla tr.impar {
    background: white;
}
 </style>