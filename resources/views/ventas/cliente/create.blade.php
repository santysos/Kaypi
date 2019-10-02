@extends('adminlte::page')

@section('title', 'Nuevo Cliente')

@section('content_header')

    <h1>Crear nuevo cliente </h1>

@stop

@section('content')
{!!Form::open(array('url'=>'ventas/cliente','method'=>'POST','autocomplete'=>'off'))!!}
{!!Form::token()!!}
<div class="container-fluid">
<div class="row">
    <div class="panel ">
        <div class="panel-body">
            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                @if(count($errors)>0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>
                            {{$error}}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
              
            </div>
            
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('codigo', 'Número CED / RUC') !!}
                    {!!Form::number('cedula_ruc',null,['class'=>'form-control', 'placeholder'=>'1001001001001' ,'required' => 'required'])!!}
                </div>
                <div class="form-group">
                    {!! Form::label('nombre', 'Nombre de Cliente') !!}
                    {!! Form::text('razon_social',null,['class'=>'form-control','placeholder'=>'Razón Social','required' => 'required'])!!}
                </div>
                 <div class="form-group">
                    {!! Form::label('nombre', 'Nombre Comercial') !!}
                    {!! Form::text('nombre_comercial',null,['class'=>'form-control','placeholder'=>'Nombre Comercial (Empresa)'])!!}
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
               
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
                <div class="form-group">
                    {!! Form::label('stock', 'Teléfono') !!}
                    {!! Form::text('telefono', null, ['class' => 'form-control','placeholder'=>'Teléfono...']) !!}
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
                <div class="form-group">
                    {!! Form::label('pais_l', 'País') !!}
                    {!! Form::select('pais',[ 'AF' => 'Afganistán','AL' => 'Albania','DE' => 'Alemania','AD' => 'Andorra',
                        'AO' => 'Angola','AI' => 'Anguilla','AQ' => 'Antártida','AG' => 'Antigua y Barbuda','AN' => 'Antillas Holandesas',
                        'SA' => 'Arabia Saudí','DZ' => 'Argelia',
                        'AR' => 'Argentina',
                        'AM' => 'Armenia',
                        'AW' => 'Aruba',
                        'AU' => 'Australia',
                        'AT' => 'Austria',
                        'AZ' => 'Azerbaiyán',
                        'BS' => 'Bahamas',
                        'BH' => 'Bahrein',
                        'BD' => 'Bangladesh',
                        'BB' => 'Barbados',
                        'BE' => 'Bélgica',
                        'BZ' => 'Belice',
                        'BJ' => 'Benin',
                        'BM' => 'Bermudas',
                        'BY' => 'Bielorrusia',
                        'MM' => 'Birmania',
                        'BO' => 'Bolivia',
                        'BA' => 'Bosnia y Herzegovina',
                        'BW' => 'Botswana',
                        'BR' => 'Brasil',
                        'BN' => 'Brunei',
                        'BG' => 'Bulgaria',
                        'BF' => 'Burkina Faso',
                        'BI' => 'Burundi',
                        'BT' => 'Bután',
                        'CV' => 'Cabo Verde',
                        'KH' => 'Camboya',
                        'CM' => 'Camerún',
                        'CA' => 'Canadá',
                        'TD' => 'Chad',
                        'CL' => 'Chile',
                        'CN' => 'China',
                        'CY' => 'Chipre',
                        'VA' => 'Ciudad del Vaticano (Santa Sede)',
                        'CO' => 'Colombia',
                        'KM' => 'Comores',
                        'CG' => 'Congo',
                        'CD' => 'Congo, República Democrática del',
                        'KR' => 'Corea',
                        'KP' => 'Corea del Norte',
                        'CI' => 'Costa de Marfíl',
                        'CR' => 'Costa Rica',
                        'HR' => 'Croacia (Hrvatska)',
                        'CU' => 'Cuba',
                        'DK' => 'Dinamarca',
                        'DJ' => 'Djibouti',
                        'DM' => 'Dominica',
                        'EC' => 'Ecuador',
                        'EG' => 'Egipto',
                        'SV' => 'El Salvador',
                        'AE' => 'Emiratos Árabes Unidos',
                        'ER' => 'Eritrea',
                        'SI' => 'Eslovenia',
                        'ES' => 'España',
                        'US' => 'Estados Unidos',
                        'EE' => 'Estonia',
                        'ET' => 'Etiopía',
                        'FJ' => 'Fiji',
                        'PH' => 'Filipinas',
                        'FI' => 'Finlandia',
                        'FR' => 'Francia',
                        'GA' => 'Gabón',
                        'GM' => 'Gambia',
                        'GE' => 'Georgia',
                        'GH' => 'Ghana',
                        'GI' => 'Gibraltar',
                        'GD' => 'Granada',
                        'GR' => 'Grecia',
                        'GL' => 'Groenlandia',
                        'GP' => 'Guadalupe',
                        'GU' => 'Guam',
                        'GT' => 'Guatemala',
                        'GY' => 'Guayana',
                        'GF' => 'Guayana Francesa',
                        'GN' => 'Guinea',
                        'GQ' => 'Guinea Ecuatorial',
                        'GW' => 'Guinea-Bissau',
                        'HT' => 'Haití',
                        'HN' => 'Honduras',
                        'HU' => 'Hungría',
                        'IN' => 'India',
                        'ID' => 'Indonesia',
                        'IQ' => 'Irak',
                        'IR' => 'Irán',
                        'IE' => 'Irlanda',
                        'BV' => 'Isla Bouvet',
                        'CX' => 'Isla de Christmas',
                        'IS' => 'Islandia',
                        'KY' => 'Islas Caimán',
                        'CK' => 'Islas Cook',
                        'CC' => 'Islas de Cocos o Keeling',
                        'FO' => 'Islas Faroe',
                        'HM' => 'Islas Heard y McDonald',
                        'FK' => 'Islas Malvinas',
                        'MP' => 'Islas Marianas del Norte',
                        'MH' => 'Islas Marshall',
                        'UM' => 'Islas menores de Estados Unidos',
                        'PW' => 'Islas Palau',
                        'SB' => 'Islas Salomón',
                        'SJ' => 'Islas Svalbard y Jan Mayen',
                        'TK' => 'Islas Tokelau',
                        'TC' => 'Islas Turks y Caicos',
                        'VI' => 'Islas Vírgenes (EEUU)',
                        'VG' => 'Islas Vírgenes (Reino Unido)',
                        'WF' => 'Islas Wallis y Futuna',
                        'IL' => 'Israel',
                        'IT' => 'Italia',
                        'JM' => 'Jamaica',
                        'JP' => 'Japón',
                        'JO' => 'Jordania',
                        'KZ' => 'Kazajistán',
                        'KE' => 'Kenia',
                        'KG' => 'Kirguizistán',
                        'KI' => 'Kiribati',
                        'KW' => 'Kuwait',
                        'LA' => 'Laos',
                        'LS' => 'Lesotho',
                        'LV' => 'Letonia',
                        'LB' => 'Líbano',
                        'LR' => 'Liberia',
                        'LY' => 'Libia',
                        'LI' => 'Liechtenstein',
                        'LT' => 'Lituania',
                        'LU' => 'Luxemburgo',
                        'MK' => 'Macedonia, Ex-República Yugoslava de',
                        'MG' => 'Madagascar',
                        'MY' => 'Malasia',
                        'MW' => 'Malawi',
                        'MV' => 'Maldivas',
                        'ML' => 'Malí',
                        'MT' => 'Malta',
                        'MA' => 'Marruecos',
                        'MQ' => 'Martinica',
                        'MU' => 'Mauricio',
                        'MR' => 'Mauritania',
                        'YT' => 'Mayotte',
                        'MX' => 'México',
                        'FM' => 'Micronesia',
                        'MD' => 'Moldavia',
                        'MC' => 'Mónaco',
                        'MN' => 'Mongolia',
                        'MS' => 'Montserrat',
                        'MZ' => 'Mozambique',
                        'NA' => 'Namibia',
                        'NR' => 'Nauru',
                        'NP' => 'Nepal',
                        'NI' => 'Nicaragua',
                        'NE' => 'Níger',
                        'NG' => 'Nigeria',
                        'NU' => 'Niue',
                        'NF' => 'Norfolk',
                        'NO' => 'Noruega',
                        'NC' => 'Nueva Caledonia',
                        'NZ' => 'Nueva Zelanda',
                        'OM' => 'Omán',
                        'NL' => 'Países Bajos',
                        'PA' => 'Panamá',
                        'PG' => 'Papúa Nueva Guinea',
                        'PK' => 'Paquistán',
                        'PY' => 'Paraguay',
                        'PE' => 'Perú',
                        'PN' => 'Pitcairn',
                        'PF' => 'Polinesia Francesa',
                        'PL' => 'Polonia',
                        'PT' => 'Portugal',
                        'PR' => 'Puerto Rico',
                        'QA' => 'Qatar',
                        'UK' => 'Reino Unido',
                        'CF' => 'República Centroafricana',
                        'CZ' => 'República Checa',
                        'ZA' => 'República de Sudáfrica',
                        'DO' => 'República Dominicana',
                        'SK' => 'República Eslovaca',
                        'RE' => 'Reunión',
                        'RW' => 'Ruanda',
                        'RO' => 'Rumania',
                        'RU' => 'Rusia',
                        'EH' => 'Sahara Occidental',
                        'KN' => 'Saint Kitts y Nevis',
                        'WS' => 'Samoa',
                        'AS' => 'Samoa Americana',
                        'SM' => 'San Marino',
                        'VC' => 'San Vicente y Granadinas',
                        'SH' => 'Santa Helena',
                        'LC' => 'Santa Lucía',
                        'ST' => 'Santo Tomé y Príncipe',
                        'SN' => 'Senegal',
                        'SC' => 'Seychelles',
                        'SL' => 'Sierra Leona',
                        'SG' => 'Singapur',
                        'SY' => 'Siria',
                        'SO' => 'Somalia',
                        'LK' => 'Sri Lanka',
                        'PM' => 'St Pierre y Miquelon',
                        'SZ' => 'Suazilandia',
                        'SD' => 'Sudán',
                        'SE' => 'Suecia',
                        'CH' => 'Suiza',
                        'SR' => 'Surinam',
                        'TH' => 'Tailandia',
                        'TW' => 'Taiwán',
                        'TZ' => 'Tanzania',
                        'TJ' => 'Tayikistán',
                        'TF' => 'Territorios franceses del Sur',
                        'TP' => 'Timor Oriental',
                        'TG' => 'Togo',
                        'TO' => 'Tonga',
                        'TT' => 'Trinidad y Tobago',
                        'TN' => 'Túnez',
                        'TM' => 'Turkmenistán',
                        'TR' => 'Turquía',
                        'TV' => 'Tuvalu',
                        'UA' => 'Ucrania',
                        'UG' => 'Uganda',
                        'UY' => 'Uruguay',
                        'UZ' => 'Uzbekistán',
                        'VU' => 'Vanuatu',
                        'VE' => 'Venezuela',
                        'VN' => 'Vietnam',
                        'YE' => 'Yemen',
                        'YU' => 'Yugoslavia',
                        'ZM' => 'Zambia',
                        'ZW' => 'Zimbabue'],null,['class' => 'form-control' ,'placeholder'=>'Seleccione el País'])!!}
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
                <div class="form-group">
                    {!! Form::label('descripcion', 'Email') !!}
                    {!! Form::email('email', 'notiene@hotmail.com', ['class' => 'form-control' ,'placeholder'=>'Email...']) !!}
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('direccion', 'Ciudad') !!}
                    {!! Form::text('ciudad', null, ['class' => 'form-control','placeholder'=>'Ciudad...' ]) !!}
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('direccion', 'Dirección') !!}
                    {!! Form::text('direccion', null, ['class' => 'form-control','placeholder'=>'Direccion...' ]) !!}
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group" aria-label="First group">
                        <button class="btn btn-primary" type="submit">
                            Guardar
                        </button>
                    </div>        
                    <button class="btn btn-danger" type="reset">
                            Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
{!!Form::close()!!}
</div>
@stop

@section('css')
    
@stop

@section('js')
    <script> console.log('Hi desde crear cliente'); </script>
@stop


