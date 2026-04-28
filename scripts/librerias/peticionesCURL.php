<?php

/**
 * Petición por GET a la URL que se indique.
 *
 * @param string $url URL del servicio
 * @param string|null $busqueda parámetros tipo: par1=val1&par2=val2
 * @return string|false respuesta o false en caso de error
 */
function petCURLGet(string $url, ?string $busqueda = null): string|false {

    $curl = curl_init();

    if ($busqueda != null) {
        $url .= "?" . $busqueda;
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPGET, 1);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $devuelto = curl_exec($curl);

    curl_close($curl);

    return $devuelto;
}


/**
 * Petición por POST a la URL que se indique.
 *
 * @param string $url URL del servicio
 * @param string|null $busqueda parámetros tipo: par1=val1&par2=val2
 * @return string|false respuesta o false en caso de error
 */
function petCURLPost(string $url, ?string $busqueda = null): string|false {

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    if ($busqueda != null) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $busqueda);
    }

    $devuelto = curl_exec($curl);

    curl_close($curl);

    return $devuelto;
}


/**
 * Petición por PUT a la URL que se indique.
 *
 * @param string $url URL del servicio
 * @param string|null $busqueda parámetros tipo: par1=val1&par2=val2
 * @return string|false respuesta o false en caso de error
 */
function petCURLPUT(string $url, ?string $busqueda = null): string|false {

    
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    if ($busqueda != null) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $busqueda);
    }

    $devuelto = curl_exec($curl);

    curl_close($curl);

    return $devuelto;
}


/**
 * Petición por DELETE a la URL que se indique.
 *
 * @param string $url URL del servicio
 * @param string|null $busqueda parámetros tipo: par1=val1&par2=val2
 * @return string|false respuesta o false en caso de error
 */
function petCURLDelete(string $url, ?string $busqueda = null): string|false {

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    if ($busqueda != null) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $busqueda);
    }

    $devuelto = curl_exec($curl);

    curl_close($curl);

    return $devuelto;
}