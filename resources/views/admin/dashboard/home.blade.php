@extends('layouts.admin.admin-layout')

@section('title')
    Dashboard
@endsection

@section('add_css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

    <style>
        .leaflet-container {
            height: 400px;
            width: 600px;
            max-width: 100%;
            max-height: 100%;
        }
    </style>

    <style>
        #map {
            width: 100%
        }

        .info { padding: 6px 8px;
                font: 14px/16px Arial, Helvetica, sans-serif;
                background: white; background: rgba(255,255,255,0.8);
                box-shadow: 0 0 15px rgba(0,0,0,0.2);
                border-radius: 5px;
            }
        .info h4 { margin: 0 0 5px;
                   color: #777;
                }

        /*Legend specific*/
        .legend {
            padding: 6px 8px;
            font: 14px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255, 255, 255, 0.8);
            /*box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);*/
            /*border-radius: 5px;*/
            line-height: 24px;
            color: #555;
        }

        .legend h4 {
            text-align: center;
            font-size: 16px;
            margin: 2px 12px 8px;
            color: #777;
        }

        .legend span {
            position: relative;
            bottom: 3px;
        }

        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin: 0 8px 0 0;
            opacity: 0.7;
        }

        .legend i.icon {
            background-size: 18px;
            background-color: rgba(255, 255, 255, 1);
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                    </li>
                </ol>
            </nav>

            <div class="card border-opacity-100 border-1">
                <div class="card-header border-info">
                    <h6 class="mt-2">Peta Potensi Desa Keseluruhan</h6>
                </div>
                <div class="card-body">
                    <div id='map'>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script>
        var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            mbUrl =
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';

        var satellite = L.tileLayer(mbUrl, {
                id: 'mapbox/satellite-v9',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
             }),
            dark = L.tileLayer(mbUrl, {
                id: 'mapbox/dark-v10',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            }),
            streets = L.tileLayer(mbUrl, {
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            });

        var map = L.map('map', {

            center: [{{ $lokasi->location }}],
            zoom: 11,
            layers: [streets]
        });

        var baseLayers = {
            "Grayscale": dark,
            "Satellite": satellite,
            "Streets": streets
        };

        var overlays = {
            "Streets": streets,
            "Grayscale": dark,
            "Satellite": satellite,
        };
         L.control.layers(baseLayers, overlays).addTo(map);

        var legend = L.control({
            position: "bottomleft"
        });

        legend.onAdd = function(map) {
            var div = L.DomUtil.create("div", "legend");
            div.innerHTML += "<h4>Desa</h4>";
            div.innerHTML += '<i style="background: #9CFF2E"></i><span>Desa Kalimas</span><br>';
            div.innerHTML += '<i style="background: #EA047E"></i><span>Desa Pal Sembilan</span><br>';
            div.innerHTML += '<i style="background: #645CAA"></i><span>Desa Punggur Besar</span><br>';
            div.innerHTML += '<i style="background: #DC3535"></i><span>Desa Punggur Kecil</span><br>';
            div.innerHTML += '<i style="background: #FED049"></i><span>Desa Punggur Kapuas</span><br>';
            return div;
        };

        legend.addTo(map);

       const info = L.control({
        position :"bottomright"
       });

	    info.onAdd = function (map) {
            this._div = L.DomUtil.create('div', 'info');
            this.update();
            return this._div;
	    };


        info.update = function (props) {
		const contents = props ? `<b>${props.nama_desa}</b><br />Batas ${props.batas}` : 'Arahkan ke Layer Untuk Mengetahui Informasi Desa';
		this._div.innerHTML = `<h4>Informasi Desa</h4>${contents}`;
	    };

        info.addTo(map);

        function highlightFeature(e) {
            const layer = e.target;
            layer.setStyle({
                weight: 5,
                color: '#666',
                dashArray: '',
                fillOpacity: 0.7
            });
            layer.bringToFront();
            info.update(layer.feature.properties);
        }

        function resetHighlight(e) {
            DesaKalimasLayer.resetStyle(e.target);
            info.update();
        }

        function zoomToFeature(e) {
            map.fitBounds(e.target.getBounds());
        }

        function onEachFeature(feature, layer) {
            let popupContent = `<p>${feature.properties.popPupContent}</p>`;
            if (feature.properties && feature.properties.popupContent) {
                popupContent += feature.properties.popupContent;
            }

            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
                click: zoomToFeature
            }).bindPopup(popupContent);
        }

        var batasKalimas = {
            type: "Feature",
            properties: {
                popPupContent: "Selamat Datang di Desa Kalimas",
                nama_desa: "Desa Kalimas",
                batas: "Utara",
                style: {
                    weight: 2,
                    color: "white",
                    dashArray: '3',
                    opacity: 1,
                    fillColor: "#9CFF2E",
                    fillOpacity: 0.8
                }
            },
            geometry: {
                type: "MultiPolygon",
                coordinates: [
                    [
                        [
                            [
                                109.2968542,
                                -0.08751542
                            ],
                            [
                                109.29610073,
                                -0.09019173
                            ],
                            [
                                109.29618591,
                                -0.0907199
                            ],
                            [
                                109.29631,
                                -0.09148922
                            ],
                            [
                                109.27879509,
                                -0.09524242
                            ],
                            [
                                109.27755914,
                                -0.09550726
                            ],
                            [
                                109.27734417,
                                -0.09556286
                            ],
                            [
                                109.27513157,
                                -0.09613508
                            ],
                            [
                                109.26928485,
                                -0.10029242
                            ],
                            [
                                109.26818313,
                                -0.10111824
                            ],
                            [
                                109.26705997,
                                -0.10190502
                            ],
                            [
                                109.26444731,
                                -0.10379383
                            ],
                            [
                                109.26220147,
                                -0.10543164
                            ],
                            [
                                109.25799916,
                                -0.10843066
                            ],
                            [
                                109.25612959,
                                -0.10980061
                            ],
                            [
                                109.25403686,
                                -0.11113996
                            ],
                            [
                                109.25336824,
                                -0.11128277
                            ],
                            [
                                109.25052355,
                                -0.11196955
                            ],
                            [
                                109.24967557,
                                -0.1120661
                            ],
                            [
                                109.24191733,
                                -0.11294946
                            ],
                            [
                                109.2415554,
                                -0.11294946
                            ],
                            [
                                109.24091641,
                                -0.11299697
                            ],
                            [
                                109.23621006,
                                -0.11349713
                            ],
                            [
                                109.23557511,
                                -0.11353797
                            ],
                            [
                                109.23556579,
                                -0.1135411
                            ],
                            [
                                109.23543518,
                                -0.11358499
                            ],
                            [
                                109.23527882,
                                -0.11364225
                            ],
                            [
                                109.23485444,
                                -0.11378885
                            ],
                            [
                                109.23479792,
                                -0.11380662
                            ],
                            [
                                109.23473669,
                                -0.11382929
                            ],
                            [
                                109.23461564,
                                -0.11392793
                            ],
                            [
                                109.2345551,
                                -0.11399856
                            ],
                            [
                                109.2345221,
                                -0.11404224
                            ],
                            [
                                109.23446231,
                                -0.11405892
                            ],
                            [
                                109.23441891,
                                -0.11407103
                            ],
                            [
                                109.2343485,
                                -0.11409067
                            ],
                            [
                                109.23403536,
                                -0.11410879
                            ],
                            [
                                109.2340352,
                                -0.11410894
                            ],
                            [
                                109.23400434,
                                -0.11413884
                            ],
                            [
                                109.23395554,
                                -0.11419008
                            ],
                            [
                                109.23394125,
                                -0.11425606
                            ],
                            [
                                109.23390539,
                                -0.11442155
                            ],
                            [
                                109.23387407,
                                -0.11444616
                            ],
                            [
                                109.23384385,
                                -0.11445816
                            ],
                            [
                                109.23374705,
                                -0.11444241
                            ],
                            [
                                109.23373257,
                                -0.11444005
                            ],
                            [
                                109.23365561,
                                -0.11438746
                            ],
                            [
                                109.23356991,
                                -0.11433292
                            ],
                            [
                                109.23356785,
                                -0.11433264
                            ],
                            [
                                109.23349938,
                                -0.11432612
                            ],
                            [
                                109.23331488,
                                -0.11448917
                            ],
                            [
                                109.23320875,
                                -0.11458295
                            ],
                            [
                                109.23309852,
                                -0.11460826
                            ],
                            [
                                109.23306613,
                                -0.11461927
                            ],
                            [
                                109.23306318,
                                -0.11462027
                            ],
                            [
                                109.23297674,
                                -0.11464965
                            ],
                            [
                                109.23287554,
                                -0.11469392
                            ],
                            [
                                109.23278698,
                                -0.114742
                            ],
                            [
                                109.23277502,
                                -0.11474948
                            ],
                            [
                                109.23277313,
                                -0.11474952
                            ],
                            [
                                109.23277264,
                                -0.11474978
                            ],
                            [
                                109.23204463,
                                -0.11477548
                            ],
                            [
                                109.23203637,
                                -0.11477577
                            ],
                            [
                                109.23200863,
                                -0.11479831
                            ],
                            [
                                109.23190312,
                                -0.11486522
                            ],
                            [
                                109.23170557,
                                -0.11500313
                            ],
                            [
                                109.23169865,
                                -0.11500796
                            ],
                            [
                                109.23169792,
                                -0.11500813
                            ],
                            [
                                109.23169175,
                                -0.11501217
                            ],
                            [
                                109.23152531,
                                -0.11505728
                            ],
                            [
                                109.23149499,
                                -0.11510926
                            ],
                            [
                                109.23136454,
                                -0.11519508
                            ],
                            [
                                109.23132057,
                                -0.11523172
                            ],
                            [
                                109.23116626,
                                -0.11521629
                            ],
                            [
                                109.23115416,
                                -0.11521968
                            ],
                            [
                                109.23086175,
                                -0.11530619
                            ],
                            [
                                109.23065315,
                                -0.11542847
                            ],
                            [
                                109.23064786,
                                -0.11543064
                            ],
                            [
                                109.23058379,
                                -0.1154569
                            ],
                            [
                                109.23043923,
                                -0.11551614
                            ],
                            [
                                109.23038192,
                                -0.11553803
                            ],
                            [
                                109.2302624,
                                -0.11561771
                            ],
                            [
                                109.23016104,
                                -0.11568528
                            ],
                            [
                                109.23011574,
                                -0.11574706
                            ],
                            [
                                109.23005517,
                                -0.11584127
                            ],
                            [
                                109.22999106,
                                -0.1158785
                            ],
                            [
                                109.22998609,
                                -0.11588271
                            ],
                            [
                                109.2299794,
                                -0.11588527
                            ],
                            [
                                109.22993557,
                                -0.11591072
                            ],
                            [
                                109.22989699,
                                -0.11593001
                            ],
                            [
                                109.22966938,
                                -0.11587599
                            ],
                            [
                                109.22963688,
                                -0.11587886
                            ],
                            [
                                109.22962832,
                                -0.11588018
                            ],
                            [
                                109.22961521,
                                -0.11588077
                            ],
                            [
                                109.22953304,
                                -0.11588451
                            ],
                            [
                                109.22950437,
                                -0.11586046
                            ],
                            [
                                109.22941177,
                                -0.1158975
                            ],
                            [
                                109.22941177,
                                -0.1158991
                            ],
                            [
                                109.22939161,
                                -0.11590686
                            ],
                            [
                                109.22939875,
                                -0.1159569
                            ],
                            [
                                109.22935666,
                                -0.11602292
                            ],
                            [
                                109.22927305,
                                -0.11614453
                            ],
                            [
                                109.22916491,
                                -0.11621367
                            ],
                            [
                                109.22900169,
                                -0.11612492
                            ],
                            [
                                109.22893103,
                                -0.11615736
                            ],
                            [
                                109.22885226,
                                -0.11643126
                            ],
                            [
                                109.22882304,
                                -0.11645036
                            ],
                            [
                                109.22873446,
                                -0.11650827
                            ],
                            [
                                109.22870149,
                                -0.11652983
                            ],
                            [
                                109.22869685,
                                -0.11652797
                            ],
                            [
                                109.22863652,
                                -0.11650384
                            ],
                            [
                                109.22848927,
                                -0.11639124
                            ],
                            [
                                109.22828138,
                                -0.11637391
                            ],
                            [
                                109.22811304,
                                -0.11642325
                            ],
                            [
                                109.22803018,
                                -0.11644754
                            ],
                            [
                                109.22793309,
                                -0.11647433
                            ],
                            [
                                109.22764782,
                                -0.11655885
                            ],
                            [
                                109.22752856,
                                -0.11651661
                            ],
                            [
                                109.22746264,
                                -0.11649326
                            ],
                            [
                                109.22732375,
                                -0.11653184
                            ],
                            [
                                109.22724416,
                                -0.11659154
                            ],
                            [
                                109.22707684,
                                -0.11671703
                            ],
                            [
                                109.22697674,
                                -0.11666698
                            ],
                            [
                                109.22697654,
                                -0.11666687
                            ],
                            [
                                109.22680293,
                                -0.11641996
                            ],
                            [
                                109.22667294,
                                -0.11630297
                            ],
                            [
                                109.2266479,
                                -0.11628122
                            ],
                            [
                                109.22649204,
                                -0.11631303
                            ],
                            [
                                109.22645957,
                                -0.11631966
                            ],
                            [
                                109.22645806,
                                -0.11632193
                            ],
                            [
                                109.22645802,
                                -0.11632194
                            ],
                            [
                                109.22635841,
                                -0.1164692
                            ],
                            [
                                109.22605716,
                                -0.1162593
                            ],
                            [
                                109.22596472,
                                -0.11623908
                            ],
                            [
                                109.22577589,
                                -0.11619776
                            ],
                            [
                                109.225769,
                                -0.1161962
                            ],
                            [
                                109.22553704,
                                -0.11624332
                            ],
                            [
                                109.22552209,
                                -0.11624636
                            ],
                            [
                                109.22530605,
                                -0.1161962
                            ],
                            [
                                109.22517102,
                                -0.11602645
                            ],
                            [
                                109.22505828,
                                -0.1159513
                            ],
                            [
                                109.22489973,
                                -0.11600737
                            ],
                            [
                                109.22470829,
                                -0.11607507
                            ],
                            [
                                109.22454169,
                                -0.11610423
                            ],
                            [
                                109.22453505,
                                -0.11610539
                            ],
                            [
                                109.22450149,
                                -0.11608547
                            ],
                            [
                                109.22433394,
                                -0.11600728
                            ],
                            [
                                109.22396739,
                                -0.11571404
                            ],
                            [
                                109.22379435,
                                -0.11564194
                            ],
                            [
                                109.2237719,
                                -0.11563258
                            ],
                            [
                                109.22376697,
                                -0.11563167
                            ],
                            [
                                109.2237598,
                                -0.11562898
                            ],
                            [
                                109.22375473,
                                -0.11562784
                            ],
                            [
                                109.22354758,
                                -0.11558134
                            ],
                            [
                                109.22335377,
                                -0.1156339
                            ],
                            [
                                109.22328317,
                                -0.11564887
                            ],
                            [
                                109.2231095,
                                -0.11584051
                            ],
                            [
                                109.22304695,
                                -0.11590953
                            ],
                            [
                                109.22293903,
                                -0.11595269
                            ],
                            [
                                109.22291994,
                                -0.11595639
                            ],
                            [
                                109.22267214,
                                -0.11585314
                            ],
                            [
                                109.22263153,
                                -0.11583622
                            ],
                            [
                                109.22233829,
                                -0.1155104
                            ],
                            [
                                109.22218493,
                                -0.11515768
                            ],
                            [
                                109.22213373,
                                -0.11511785
                            ],
                            [
                                109.22211836,
                                -0.11511127
                            ],
                            [
                                109.22195924,
                                -0.11518287
                            ],
                            [
                                109.22178052,
                                -0.11542542
                            ],
                            [
                                109.22175139,
                                -0.11544986
                            ],
                            [
                                109.22166754,
                                -0.11552018
                            ],
                            [
                                109.22157261,
                                -0.11555927
                            ],
                            [
                                109.22147754,
                                -0.11547099
                            ],
                            [
                                109.22145857,
                                -0.11545338
                            ],
                            [
                                109.22145238,
                                -0.11543211
                            ],
                            [
                                109.22139196,
                                -0.11522458
                            ],
                            [
                                109.22137527,
                                -0.11516726
                            ],
                            [
                                109.22128089,
                                -0.11484309
                            ],
                            [
                                109.22127123,
                                -0.11480988
                            ],
                            [
                                109.2212224,
                                -0.11459993
                            ],
                            [
                                109.22117418,
                                -0.11445527
                            ],
                            [
                                109.22107457,
                                -0.11430802
                            ],
                            [
                                109.22091865,
                                -0.11426038
                            ],
                            [
                                109.22053344,
                                -0.11459641
                            ],
                            [
                                109.22048926,
                                -0.11463883
                            ],
                            [
                                109.22029558,
                                -0.11480927
                            ],
                            [
                                109.22028562,
                                -0.11481803
                            ],
                            [
                                109.22009827,
                                -0.11505425
                            ],
                            [
                                109.21998988,
                                -0.11507593
                            ],
                            [
                                109.21996244,
                                -0.11507186
                            ],
                            [
                                109.21991627,
                                -0.11504878
                            ],
                            [
                                109.21990519,
                                -0.11501831
                            ],
                            [
                                109.21979259,
                                -0.11491003
                            ],
                            [
                                109.21977526,
                                -0.1148494
                            ],
                            [
                                109.2197265,
                                -0.11462851
                            ],
                            [
                                109.21970456,
                                -0.11452915
                            ],
                            [
                                109.21960954,
                                -0.11435374
                            ],
                            [
                                109.21944568,
                                -0.11431277
                            ],
                            [
                                109.21934791,
                                -0.1143214
                            ],
                            [
                                109.21928134,
                                -0.11433804
                            ],
                            [
                                109.21911695,
                                -0.11443362
                            ],
                            [
                                109.21873415,
                                -0.11468031
                            ],
                            [
                                109.21872716,
                                -0.11468482
                            ],
                            [
                                109.21872649,
                                -0.11468574
                            ],
                            [
                                109.21865732,
                                -0.11478139
                            ],
                            [
                                109.21855392,
                                -0.11477577
                            ],
                            [
                                109.21847596,
                                -0.11474545
                            ],
                            [
                                109.21840666,
                                -0.11466749
                            ],
                            [
                                109.21840162,
                                -0.11466124
                            ],
                            [
                                109.21818589,
                                -0.11439357
                            ],
                            [
                                109.21817279,
                                -0.11437732
                            ],
                            [
                                109.21800388,
                                -0.1142214
                            ],
                            [
                                109.2179,
                                -0.11412871
                            ],
                            [
                                109.21772236,
                                -0.1139702
                            ],
                            [
                                109.21772189,
                                -0.11396953
                            ],
                            [
                                109.21748849,
                                -0.11363238
                            ],
                            [
                                109.21736449,
                                -0.11346104
                            ],
                            [
                                109.21722671,
                                -0.11328132
                            ],
                            [
                                109.21704768,
                                -0.11299448
                            ],
                            [
                                109.21699729,
                                -0.11296115
                            ],
                            [
                                109.21695633,
                                -0.11294765
                            ],
                            [
                                109.21675498,
                                -0.11297642
                            ],
                            [
                                109.21649434,
                                -0.11290757
                            ],
                            [
                                109.2164912,
                                -0.11290485
                            ],
                            [
                                109.21643376,
                                -0.11291008
                            ],
                            [
                                109.21639136,
                                -0.11285928
                            ],
                            [
                                109.21624821,
                                -0.11269809
                            ],
                            [
                                109.21603179,
                                -0.11253352
                            ],
                            [
                                109.21575789,
                                -0.11242306
                            ],
                            [
                                109.21563934,
                                -0.11240926
                            ],
                            [
                                109.21502787,
                                -0.11241949
                            ],
                            [
                                109.21425199,
                                -0.11289985
                            ],
                            [
                                109.21372547,
                                -0.11314307
                            ],
                            [
                                109.21317581,
                                -0.11325729
                            ],
                            [
                                109.21266185,
                                -0.11325729
                            ],
                            [
                                109.21197656,
                                -0.11314307
                            ],
                            [
                                109.21131269,
                                -0.11296461
                            ],
                            [
                                109.21018483,
                                -0.1125149
                            ],
                            [
                                109.2089713,
                                -0.11191527
                            ],
                            [
                                109.20865722,
                                -0.11167971
                            ],
                            [
                                109.20836454,
                                -0.11121571
                            ],
                            [
                                109.20803618,
                                -0.1104519
                            ],
                            [
                                109.20745797,
                                -0.10913844
                            ],
                            [
                                109.20697327,
                                -0.10832823
                            ],
                            [
                                109.20600031,
                                -0.10699169
                            ],
                            [
                                109.20549332,
                                -0.10635473
                            ],
                            [
                                109.20466269,
                                -0.10474312
                            ],
                            [
                                109.20431053,
                                -0.10361049
                            ],
                            [
                                109.20397741,
                                -0.10218282
                            ],
                            [
                                109.2037585,
                                -0.10127862
                            ],
                            [
                                109.20353959,
                                -0.10065996
                            ],
                            [
                                109.20329213,
                                -0.100146
                            ],
                            [
                                109.20296852,
                                -0.09975577
                            ],
                            [
                                109.20246407,
                                -0.09920373
                            ],
                            [
                                109.2017312,
                                -0.09860411
                            ],
                            [
                                109.20057002,
                                -0.09778557
                            ],
                            [
                                109.1998657,
                                -0.09733585
                            ],
                            [
                                109.19918756,
                                -0.09699321
                            ],
                            [
                                109.19863005,
                                -0.09672302
                            ],
                            [
                                109.19824814,
                                -0.09660167
                            ],
                            [
                                109.19750139,
                                -0.09653941
                            ],
                            [
                                109.19676376,
                                -0.09649777
                            ],
                            [
                                109.19604397,
                                -0.09645613
                            ],
                            [
                                109.19404079,
                                -0.09642958
                            ],
                            [
                                109.19352665,
                                -0.09643234
                            ],
                            [
                                109.19323636,
                                -0.09640854
                            ],
                            [
                                109.19307608,
                                -0.09639986
                            ],
                            [
                                109.19288102,
                                -0.09635917
                            ],
                            [
                                109.19192716,
                                -0.09621313
                            ],
                            [
                                109.19124542,
                                -0.09616395
                            ],
                            [
                                109.19064849,
                                -0.09612089
                            ],
                            [
                                109.18976987,
                                -0.09620804
                            ],
                            [
                                109.18917586,
                                -0.09625401
                            ],
                            [
                                109.18860469,
                                -0.09634598
                            ],
                            [
                                109.18810207,
                                -0.09640346
                            ],
                            [
                                109.1877251,
                                -0.09632294
                            ],
                            [
                                109.18703972,
                                -0.0961619
                            ],
                            [
                                109.1859431,
                                -0.09582833
                            ],
                            [
                                109.18507495,
                                -0.09559828
                            ],
                            [
                                109.18475511,
                                -0.09539126
                            ],
                            [
                                109.18463185,
                                -0.09528675
                            ],
                            [
                                109.18405742,
                                -0.09489718
                            ],
                            [
                                109.18407285,
                                -0.09488571
                            ],
                            [
                                109.18418132,
                                -0.09480525
                            ],
                            [
                                109.18428985,
                                -0.09472487
                            ],
                            [
                                109.18439838,
                                -0.0946445
                            ],
                            [
                                109.18450691,
                                -0.09456412
                            ],
                            [
                                109.18461551,
                                -0.09448384
                            ],
                            [
                                109.18472411,
                                -0.09440356
                            ],
                            [
                                109.18483272,
                                -0.09432329
                            ],
                            [
                                109.18494135,
                                -0.09424304
                            ],
                            [
                                109.18505,
                                -0.09416284
                            ],
                            [
                                109.18515865,
                                -0.09408263
                            ],
                            [
                                109.18526731,
                                -0.09400243
                            ],
                            [
                                109.18537599,
                                -0.09392226
                            ],
                            [
                                109.18548468,
                                -0.09384209
                            ],
                            [
                                109.18559336,
                                -0.09376192
                            ],
                            [
                                109.18570204,
                                -0.09368176
                            ],
                            [
                                109.18581073,
                                -0.0936016
                            ],
                            [
                                109.18591941,
                                -0.09352142
                            ],
                            [
                                109.18602807,
                                -0.09344123
                            ],
                            [
                                109.18613673,
                                -0.09336103
                            ],
                            [
                                109.18624534,
                                -0.09328076
                            ],
                            [
                                109.18635392,
                                -0.09320046
                            ],
                            [
                                109.18646243,
                                -0.09312005
                            ],
                            [
                                109.18657079,
                                -0.09303944
                            ],
                            [
                                109.1866789,
                                -0.09295848
                            ],
                            [
                                109.18678622,
                                -0.09287649
                            ],
                            [
                                109.18689183,
                                -0.09279226
                            ],
                            [
                                109.18699544,
                                -0.09270555
                            ],
                            [
                                109.18709798,
                                -0.09261757
                            ],
                            [
                                109.18720044,
                                -0.09252949
                            ],
                            [
                                109.18730307,
                                -0.0924416
                            ],
                            [
                                109.18740539,
                                -0.09235335
                            ],
                            [
                                109.1875069,
                                -0.09226417
                            ],
                            [
                                109.18760686,
                                -0.09217323
                            ],
                            [
                                109.18770403,
                                -0.09207928
                            ],
                            [
                                109.18779636,
                                -0.09198052
                            ],
                            [
                                109.18788178,
                                -0.09187568
                            ],
                            [
                                109.18795802,
                                -0.09176392
                            ],
                            [
                                109.1880218,
                                -0.09164455
                            ],
                            [
                                109.18806711,
                                -0.09151701
                            ],
                            [
                                109.18808689,
                                -0.09138311
                            ],
                            [
                                109.18807747,
                                -0.09124805
                            ],
                            [
                                109.18804567,
                                -0.09111637
                            ],
                            [
                                109.18799841,
                                -0.09098941
                            ],
                            [
                                109.18799173,
                                -0.09097582
                            ],
                            [
                                109.18803757,
                                -0.09097733
                            ],
                            [
                                109.18892273,
                                -0.09107726
                            ],
                            [
                                109.1889458,
                                -0.09107726
                            ],
                            [
                                109.18946987,
                                -0.09107726
                            ],
                            [
                                109.18960801,
                                -0.09107726
                            ],
                            [
                                109.19063594,
                                -0.09103443
                            ],
                            [
                                109.19124984,
                                -0.0909916
                            ],
                            [
                                109.19166387,
                                -0.09090594
                            ],
                            [
                                109.19200651,
                                -0.09067751
                            ],
                            [
                                109.19226587,
                                -0.09031584
                            ],
                            [
                                109.19281315,
                                -0.08955441
                            ],
                            [
                                109.19333544,
                                -0.08905591
                            ],
                            [
                                109.19369712,
                                -0.0889417
                            ],
                            [
                                109.19412542,
                                -0.08887507
                            ],
                            [
                                109.19478215,
                                -0.08887507
                            ],
                            [
                                109.19613368,
                                -0.08885604
                            ],
                            [
                                109.19697125,
                                -0.08890363
                            ],
                            [
                                109.19727582,
                                -0.0889417
                            ],
                            [
                                109.19785641,
                                -0.08912254
                            ],
                            [
                                109.19895097,
                                -0.08932241
                            ],
                            [
                                109.19905566,
                                -0.08929386
                            ],
                            [
                                109.19922698,
                                -0.0892082
                            ],
                            [
                                109.19964656,
                                -0.08881172
                            ],
                            [
                                109.20028188,
                                -0.08824828
                            ],
                            [
                                109.20050793,
                                -0.08808172
                            ],
                            [
                                109.20072208,
                                -0.08801034
                            ],
                            [
                                109.20305395,
                                -0.08790326
                            ],
                            [
                                109.20518357,
                                -0.0877486
                            ],
                            [
                                109.20512814,
                                -0.08627822
                            ],
                            [
                                109.20579509,
                                -0.08633044
                            ],
                            [
                                109.20571895,
                                -0.08445542
                            ],
                            [
                                109.20648989,
                                -0.08452205
                            ],
                            [
                                109.20663145,
                                -0.08581662
                            ],
                            [
                                109.20711498,
                                -0.08581632
                            ],
                            [
                                109.20759325,
                                -0.08483836
                            ],
                            [
                                109.20793589,
                                -0.08483836
                            ],
                            [
                                109.20971811,
                                -0.08527856
                            ],
                            [
                                109.21010536,
                                -0.08527912
                            ],
                            [
                                109.21141185,
                                -0.08536622
                            ],
                            [
                                109.21094783,
                                -0.08349646
                            ],
                            [
                                109.21077975,
                                -0.08292019
                            ],
                            [
                                109.21385869,
                                -0.08200191
                            ],
                            [
                                109.21371547,
                                -0.08149559
                            ],
                            [
                                109.21782718,
                                -0.08126717
                            ],
                            [
                                109.21769393,
                                -0.0791542
                            ],
                            [
                                109.21895029,
                                -0.07926842
                            ],
                            [
                                109.22242463,
                                -0.07944716
                            ],
                            [
                                109.22264432,
                                -0.07941775
                            ],
                            [
                                109.22364551,
                                -0.07928371
                            ],
                            [
                                109.22714004,
                                -0.07866183
                            ],
                            [
                                109.23574484,
                                -0.07740943
                            ],
                            [
                                109.24236588,
                                -0.07645937
                            ],
                            [
                                109.24493949,
                                -0.07670384
                            ],
                            [
                                109.245172,
                                -0.07672593
                            ],
                            [
                                109.24606059,
                                -0.07681034
                            ],
                            [
                                109.24824969,
                                -0.07675323
                            ],
                            [
                                109.25038169,
                                -0.07644866
                            ],
                            [
                                109.25238043,
                                -0.0759918
                            ],
                            [
                                109.25873222,
                                -0.07445197
                            ],
                            [
                                109.25915936,
                                -0.07440439
                            ],
                            [
                                109.26011173,
                                -0.07796791
                            ],
                            [
                                109.26034629,
                                -0.07884555
                            ],
                            [
                                109.26359605,
                                -0.09100527
                            ],
                            [
                                109.26359676,
                                -0.0910052
                            ],
                            [
                                109.26361018,
                                -0.09105179
                            ],
                            [
                                109.2697258,
                                -0.09040011
                            ],
                            [
                                109.27309609,
                                -0.09006737
                            ],
                            [
                                109.27810269,
                                -0.08950746
                            ],
                            [
                                109.29688391,
                                -0.08740707
                            ],
                            [
                                109.2968542,
                                -0.08751542
                            ]
                        ]
                    ]
                ]
            }
        };

        var batasSungaiBelidak = {
            type: "Feature",
            properties: {
                popPupContent: "Desa Sungai Belidak",
                nama_desa: "Desa Sungai Belidak",
                batas: "Barat",
                style: {
                    weight: 2,
                    color: "white",
                    dashArray: '3',
                    opacity: 1,
                    fillColor: "#00E7FF",
                    fillOpacity: 0.8,
                },
            },
            geometry: {
                type: "MultiPolygon",
                coordinates: [
                    [
                        [
                            [109.23743093, -0.07106526],
                            [109.23907595, -0.07090213],
                            [109.24211531, -0.07040695],
                            [109.24508575, -0.06992299],
                            [109.2488048, -0.06979517],
                            [109.25058939, -0.06979517],
                            [109.25138889, -0.06966668],
                            [109.2531021, -0.06920982],
                            [109.25639221, -0.06836105],
                            [109.25640581, -0.06691205],
                            [109.25671517, -0.0673761],
                            [109.2574114, -0.06853419],
                            [109.25746617, -0.06862695],
                            [109.25962204, -0.07209755],
                            [109.26033631, -0.07330187],
                            [109.26081771, -0.07407577],
                            [109.25976784, -0.07424153],
                            [109.25977915, -0.07433535],
                            [109.25915936, -0.07440439],
                            [109.25873222, -0.07445197],
                            [109.25238043, -0.0759918],
                            [109.25038169, -0.07644866],
                            [109.24824969, -0.07675323],
                            [109.24606059, -0.07681034],
                            [109.245172, -0.07672593],
                            [109.24493949, -0.07670384],
                            [109.24236588, -0.07645937],
                            [109.23574484, -0.07740943],
                            [109.22714004, -0.07866183],
                            [109.22364551, -0.07928371],
                            [109.22264432, -0.07941775],
                            [109.22242463, -0.07944716],
                            [109.21895029, -0.07926842],
                            [109.21769393, -0.0791542],
                            [109.21782718, -0.08126717],
                            [109.21371547, -0.08149559],
                            [109.21385869, -0.08200191],
                            [109.21077975, -0.08292019],
                            [109.21094783, -0.08349646],
                            [109.21141185, -0.08536622],
                            [109.21010536, -0.08527912],
                            [109.20971811, -0.08527856],
                            [109.20793589, -0.08483836],
                            [109.20759325, -0.08483836],
                            [109.20711498, -0.08581632],
                            [109.20663145, -0.08581662],
                            [109.20648989, -0.08452205],
                            [109.20571895, -0.08445542],
                            [109.20579509, -0.08633044],
                            [109.20512814, -0.08627822],
                            [109.20518357, -0.0877486],
                            [109.20305395, -0.08790326],
                            [109.20072208, -0.08801034],
                            [109.20050793, -0.08808172],
                            [109.20028188, -0.08824828],
                            [109.19964656, -0.08881172],
                            [109.19922698, -0.0892082],
                            [109.19905566, -0.08929386],
                            [109.19895097, -0.08932241],
                            [109.19785641, -0.08912254],
                            [109.19727582, -0.0889417],
                            [109.19697125, -0.08890363],
                            [109.19613368, -0.08885604],
                            [109.19478215, -0.08887507],
                            [109.19412542, -0.08887507],
                            [109.19369712, -0.0889417],
                            [109.19333544, -0.08905591],
                            [109.19281315, -0.08955441],
                            [109.19226587, -0.09031584],
                            [109.19200651, -0.09067751],
                            [109.19166387, -0.09090594],
                            [109.19124984, -0.0909916],
                            [109.19063594, -0.09103443],
                            [109.18960801, -0.09107726],
                            [109.18946987, -0.09107726],
                            [109.1889458, -0.09107726],
                            [109.18892273, -0.09107726],
                            [109.18803757, -0.09097733],
                            [109.18799173, -0.09097582],
                            [109.18793867, -0.09086791],
                            [109.18786743, -0.09075284],
                            [109.18778827, -0.09064311],
                            [109.1877031, -0.09053804],
                            [109.18761235, -0.09043781],
                            [109.18751673, -0.09034228],
                            [109.18741712, -0.09025095],
                            [109.18731508, -0.09016238],
                            [109.18721258, -0.09007435],
                            [109.18711058, -0.08998573],
                            [109.18700969, -0.08989583],
                            [109.18691029, -0.08980426],
                            [109.1868126, -0.08971084],
                            [109.18671661, -0.08961566],
                            [109.18666184, -0.08955969],
                            [109.18662206, -0.08951904],
                            [109.18652877, -0.08942118],
                            [109.18643664, -0.08932221],
                            [109.18634566, -0.08922217],
                            [109.1862561, -0.08912083],
                            [109.18616803, -0.08901818],
                            [109.18608152, -0.0889142],
                            [109.18599694, -0.08880863],
                            [109.18591492, -0.08870103],
                            [109.1858362, -0.08859097],
                            [109.18576127, -0.08847826],
                            [109.1856903, -0.08836298],
                            [109.1856235, -0.08824519],
                            [109.18555926, -0.08812596],
                            [109.18549545, -0.0880065],
                            [109.1854305, -0.08788766],
                            [109.18536465, -0.08776932],
                            [109.18529866, -0.08765106],
                            [109.18523341, -0.08753239],
                            [109.18517004, -0.08741269],
                            [109.18511005, -0.08729125],
                            [109.18505479, -0.08716756],
                            [109.18500531, -0.08704142],
                            [109.18496203, -0.08691297],
                            [109.18492358, -0.08678298],
                            [109.18488798, -0.08665216],
                            [109.18485338, -0.08652107],
                            [109.18481735, -0.08639037],
                            [109.18477718, -0.08626091],
                            [109.18473115, -0.08613345],
                            [109.18467953, -0.08600817],
                            [109.18462374, -0.08588471],
                            [109.1845648, -0.08576274],
                            [109.184503, -0.08564221],
                            [109.18443836, -0.0855232],
                            [109.18437097, -0.08540575],
                            [109.184301, -0.08528984],
                            [109.18422888, -0.08517527],
                            [109.18415454, -0.08506215],
                            [109.18407805, -0.08495049],
                            [109.18399981, -0.08484006],
                            [109.18392009, -0.08473072],
                            [109.18383886, -0.08462251],
                            [109.18375589, -0.08451563],
                            [109.18367074, -0.08441052],
                            [109.18358276, -0.08430781],
                            [109.18349143, -0.0842081],
                            [109.18339655, -0.0841118],
                            [109.18329826, -0.08401904],
                            [109.18319689, -0.0839297],
                            [109.18309282, -0.08384356],
                            [109.18298639, -0.08376039],
                            [109.18287783, -0.08368005],
                            [109.18276748, -0.08360223],
                            [109.18265551, -0.0835268],
                            [109.18254189, -0.08345391],
                            [109.18242641, -0.08338405],
                            [109.18230858, -0.08331829],
                            [109.18218776, -0.08325832],
                            [109.18206327, -0.08320653],
                            [109.18193536, -0.08316403],
                            [109.18180479, -0.08313067],
                            [109.18167245, -0.08310531],
                            [109.18153914, -0.08308569],
                            [109.18140529, -0.08307026],
                            [109.18127115, -0.08305757],
                            [109.18113688, -0.08304633],
                            [109.18100264, -0.08303468],
                            [109.18086866, -0.08302047],
                            [109.18073516, -0.08300224],
                            [109.18060245, -0.0829789],
                            [109.18047094, -0.08294951],
                            [109.18034115, -0.08291319],
                            [109.18021375, -0.08286916],
                            [109.1800895, -0.08281682],
                            [109.17996927, -0.08275569],
                            [109.17985432, -0.08268505],
                            [109.17974648, -0.08260385],
                            [109.17964917, -0.0825102],
                            [109.17956594, -0.08240365],
                            [109.17949197, -0.08229033],
                            [109.17942453, -0.08217291],
                            [109.17936103, -0.08205328],
                            [109.17929994, -0.08193239],
                            [109.17924021, -0.08181081],
                            [109.17918143, -0.08168876],
                            [109.17912403, -0.08156604],
                            [109.17906688, -0.08144321],
                            [109.17901084, -0.08131986],
                            [109.17895495, -0.08119644],
                            [109.17890003, -0.08107258],
                            [109.17884512, -0.08094871],
                            [109.17879128, -0.08082437],
                            [109.17873744, -0.08070003],
                            [109.17868445, -0.08057532],
                            [109.1786317, -0.08045051],
                            [109.1785795, -0.08032546],
                            [109.1785279, -0.08020016],
                            [109.17847649, -0.08007479],
                            [109.17842615, -0.07994897],
                            [109.17837582, -0.07982315],
                            [109.17832661, -0.07969688],
                            [109.17827765, -0.07957051],
                            [109.17822939, -0.07944388],
                            [109.17818175, -0.079317],
                            [109.17813448, -0.07918998],
                            [109.17808808, -0.07906263],
                            [109.17804186, -0.07893523],
                            [109.17799666, -0.07880745],
                            [109.17795157, -0.07867963],
                            [109.17790756, -0.07855143],
                            [109.17786376, -0.07842316],
                            [109.17782095, -0.07829455],
                            [109.1777787, -0.07816575],
                            [109.17773719, -0.0780367],
                            [109.17769695, -0.07790726],
                            [109.17765781, -0.07777747],
                            [109.17762039, -0.07764717],
                            [109.17758561, -0.07751613],
                            [109.17755475, -0.07738411],
                            [109.17753084, -0.07725066],
                            [109.17751477, -0.077116],
                            [109.17749935, -0.07698125],
                            [109.17747935, -0.07684713],
                            [109.17745103, -0.07671456],
                            [109.17741133, -0.07658499],
                            [109.17736631, -0.07645715],
                            [109.17731994, -0.07632979],
                            [109.17727326, -0.07620255],
                            [109.17722652, -0.07607534],
                            [109.17717981, -0.07594811],
                            [109.17713314, -0.07582087],
                            [109.17708655, -0.07569359],
                            [109.17704004, -0.07556629],
                            [109.17699355, -0.07543898],
                            [109.17694724, -0.07531161],
                            [109.17690093, -0.07518423],
                            [109.17685815, -0.07506638],
                            [109.17685469, -0.07505683],
                            [109.17680862, -0.07492936],
                            [109.17676255, -0.0748019],
                            [109.17671656, -0.0746744],
                            [109.17667079, -0.07454683],
                            [109.17662501, -0.07441926],
                            [109.17657929, -0.07429167],
                            [109.17653389, -0.07416396],
                            [109.17648849, -0.07403625],
                            [109.17644309, -0.07390854],
                            [109.17639814, -0.07378068],
                            [109.17635322, -0.07365279],
                            [109.17630831, -0.07352491],
                            [109.17626389, -0.07339686],
                            [109.17621963, -0.07326874],
                            [109.17617537, -0.07314063],
                            [109.17613181, -0.07301227],
                            [109.17608848, -0.07288384],
                            [109.17604516, -0.0727554],
                            [109.17600317, -0.07262652],
                            [109.17596118, -0.07249763],
                            [109.17592025, -0.0723684],
                            [109.17591196, -0.07234172],
                            [109.17588, -0.07223896],
                            [109.17584092, -0.07210915],
                            [109.17580285, -0.07197904],
                            [109.17576678, -0.07184836],
                            [109.17573202, -0.07171732],
                            [109.17569988, -0.07158559],
                            [109.1756709, -0.07145313],
                            [109.1756452, -0.07132],
                            [109.1756233, -0.07118618],
                            [109.17560525, -0.07105177],
                            [109.17559108, -0.07091689],
                            [109.17558102, -0.07078164],
                            [109.17557583, -0.07064611],
                            [109.17557526, -0.07051048],
                            [109.1755791, -0.07037491],
                            [109.17558728, -0.07023952],
                            [109.17559999, -0.0701045],
                            [109.17561699, -0.06996995],
                            [109.17563938, -0.06983622],
                            [109.17566798, -0.06970369],
                            [109.17570319, -0.06957279],
                            [109.17574708, -0.06944458],
                            [109.1757984, -0.0693192],
                            [109.1758564, -0.06919679],
                            [109.1759183, -0.06907632],
                            [109.17598202, -0.0689568],
                            [109.17604482, -0.0688368],
                            [109.17610458, -0.06871524],
                            [109.17615978, -0.06859152],
                            [109.17620826, -0.06846499],
                            [109.17624796, -0.06833541],
                            [109.17627685, -0.06820299],
                            [109.17629464, -0.06806859],
                            [109.17630222, -0.06793321],
                            [109.17630083, -0.06779761],
                            [109.17629191, -0.06766229],
                            [109.176277, -0.0675275],
                            [109.1762577, -0.06739326],
                            [109.17623822, -0.06727534],
                            [109.17688899, -0.06740293],
                            [109.17756314, -0.06724074],
                            [109.17779157, -0.06728357],
                            [109.17806283, -0.06737636],
                            [109.17824129, -0.06748344],
                            [109.17849827, -0.06763335],
                            [109.17876953, -0.06789747],
                            [109.17912222, -0.0681904],
                            [109.1794943, -0.06840301],
                            [109.18011084, -0.06875532],
                            [109.18088804, -0.06919944],
                            [109.18126797, -0.06925376],
                            [109.1817391, -0.06931801],
                            [109.18203177, -0.06927517],
                            [109.18223165, -0.06913241],
                            [109.18238155, -0.06891826],
                            [109.18255287, -0.06867555],
                            [109.18284555, -0.06846854],
                            [109.18320247, -0.06829722],
                            [109.18349514, -0.06813303],
                            [109.18360222, -0.06799027],
                            [109.18365219, -0.06782608],
                            [109.18375759, -0.06771717],
                            [109.18386634, -0.06760479],
                            [109.18403052, -0.06749772],
                            [109.18415187, -0.06729784],
                            [109.1841947, -0.06715508],
                            [109.18430178, -0.06704086],
                            [109.18487323, -0.06665773],
                            [109.18588688, -0.06615804],
                            [109.18615814, -0.06604383],
                            [109.18640085, -0.06577257],
                            [109.18654362, -0.06542993],
                            [109.18684343, -0.06511584],
                            [109.18735739, -0.06485886],
                            [109.18806023, -0.06451389],
                            [109.18936907, -0.06457207],
                            [109.19016696, -0.06460753],
                            [109.19155208, -0.06718894],
                            [109.19272992, -0.06858093],
                            [109.19383637, -0.06925907],
                            [109.19451451, -0.06950892],
                            [109.19537112, -0.06950892],
                            [109.19637049, -0.06943753],
                            [109.19704864, -0.06947323],
                            [109.20311835, -0.07039857],
                            [109.21343916, -0.07086224],
                            [109.21465863, -0.07074326],
                            [109.21602682, -0.07062429],
                            [109.2186012, -0.07052911],
                            [109.21819015, -0.06834793],
                            [109.21946357, -0.06861068],
                            [109.22096792, -0.06737165],
                            [109.2217915, -0.06824635],
                            [109.22257672, -0.06912675],
                            [109.22345712, -0.07010233],
                            [109.22438511, -0.07100652],
                            [109.2253131, -0.07186313],
                            [109.22588417, -0.07222005],
                            [109.22637274, -0.0723823],
                            [109.22733565, -0.07238661],
                            [109.22831122, -0.07241041],
                            [109.23160111, -0.07230219],
                            [109.23562282, -0.07170449],
                            [109.23743791, -0.07143474],
                            [109.23743093, -0.07106526],
                        ],
                    ],
                ],
            },
        };

        var batasPunggurKapuas = {
            type: "Feature",
            properties: {
                popPupContent: "Desa Punggur Kapuas",
                nama_desa: "Desa Punggur Kapuas",
                batas: "Selatan",
                style: {
                    weight: 2,
                    color: "white",
                    dashArray: '3',
                    opacity: 1,
                    fillColor: "#FED049",
                    fillOpacity: 0.8,
                },
            },
            geometry: {
                type: "MultiPolygon",
                coordinates: [
                    [
                        [
                            [109.21643376, -0.11291008],
                            [109.21651648, -0.11300919],
                            [109.21655931, -0.11307907],
                            [109.21659293, -0.113169],
                            [109.21692795, -0.11412866],
                            [109.2169448, -0.11417694],
                            [109.2170609, -0.11472587],
                            [109.21711889, -0.11501556],
                            [109.21721521, -0.11543865],
                            [109.21738548, -0.11668731],
                            [109.21740469, -0.11678634],
                            [109.21750388, -0.11735218],
                            [109.21756362, -0.11779967],
                            [109.21760129, -0.11811387],
                            [109.21763683, -0.11831597],
                            [109.21677658, -0.12038871],
                            [109.21637359, -0.12275462],
                            [109.21629136, -0.12307152],
                            [109.21651612, -0.12410542],
                            [109.21749921, -0.12533219],
                            [109.21767825, -0.12632221],
                            [109.2176704, -0.12670452],
                            [109.21699597, -0.1285617],
                            [109.21686468, -0.12974565],
                            [109.21701827, -0.1317306],
                            [109.21794666, -0.13601254],
                            [109.2179295, -0.13760793],
                            [109.21807105, -0.13857287],
                            [109.21804687, -0.13992144],
                            [109.21796712, -0.14064206],
                            [109.21794818, -0.14081313],
                            [109.21798544, -0.1409077],
                            [109.21803826, -0.14104178],
                            [109.21932055, -0.14378703],
                            [109.21964909, -0.14489023],
                            [109.21965924, -0.14572189],
                            [109.21956259, -0.14659175],
                            [109.21879664, -0.14853432],
                            [109.21550523, -0.15515838],
                            [109.21205219, -0.15902518],
                            [109.20902824, -0.16314616],
                            [109.20785637, -0.16564151],
                            [109.20764682, -0.16763223],
                            [109.20643338, -0.17086144],
                            [109.2055787, -0.1734967],
                            [109.20478969, -0.17592947],
                            [109.20474521, -0.17706142],
                            [109.20480707, -0.1784645],
                            [109.20361582, -0.17924686],
                            [109.20140226, -0.18029177],
                            [109.20029819, -0.18047261],
                            [109.19849932, -0.18055827],
                            [109.19066256, -0.1804826],
                            [109.18374789, -0.18055268],
                            [109.18376395, -0.18046115],
                            [109.1837867, -0.18032746],
                            [109.18380942, -0.18019376],
                            [109.18383131, -0.18005992],
                            [109.18385308, -0.17992606],
                            [109.1838739, -0.17979205],
                            [109.18389455, -0.17965801],
                            [109.18391424, -0.17952383],
                            [109.18393355, -0.17938959],
                            [109.18395216, -0.17925525],
                            [109.18397009, -0.17912081],
                            [109.18398765, -0.17898633],
                            [109.18400425, -0.17885172],
                            [109.1840204, -0.17871706],
                            [109.18403591, -0.17858232],
                            [109.18405043, -0.17844747],
                            [109.18406441, -0.17831256],
                            [109.18407732, -0.17817755],
                            [109.18408928, -0.17804244],
                            [109.18410059, -0.17790728],
                            [109.18411038, -0.177772],
                            [109.18411932, -0.17763666],
                            [109.18412737, -0.17750126],
                            [109.18413375, -0.17736577],
                            [109.18413932, -0.17723025],
                            [109.18414353, -0.17709467],
                            [109.18414607, -0.17695906],
                            [109.18414776, -0.17682343],
                            [109.18414716, -0.1766878],
                            [109.18414563, -0.17655217],
                            [109.18414247, -0.17641656],
                            [109.18413804, -0.176281],
                            [109.18413246, -0.17614548],
                            [109.1841257, -0.17601001],
                            [109.1841179, -0.1758746],
                            [109.18410943, -0.17573923],
                            [109.18409967, -0.17560394],
                            [109.18408991, -0.17546866],
                            [109.1840786, -0.1753335],
                            [109.18406717, -0.17519835],
                            [109.18405541, -0.17506322],
                            [109.1840426, -0.1749282],
                            [109.18402979, -0.17479317],
                            [109.18401671, -0.17465817],
                            [109.18400291, -0.17452324],
                            [109.1839891, -0.17438832],
                            [109.18397526, -0.17425339],
                            [109.18396075, -0.17411854],
                            [109.18394623, -0.17398369],
                            [109.18393172, -0.17384884],
                            [109.18391686, -0.17371402],
                            [109.18390184, -0.17357923],
                            [109.18388682, -0.17344443],
                            [109.18387173, -0.17330964],
                            [109.18385636, -0.17317489],
                            [109.18384099, -0.17304013],
                            [109.18382561, -0.17290538],
                            [109.18381009, -0.17277064],
                            [109.18379449, -0.17263591],
                            [109.18377889, -0.17250118],
                            [109.18376328, -0.17236646],
                            [109.18374758, -0.17223174],
                            [109.18373187, -0.17209702],
                            [109.18371617, -0.17196231],
                            [109.18370048, -0.17182759],
                            [109.1836848, -0.17169287],
                            [109.18366911, -0.17155815],
                            [109.18365352, -0.17142342],
                            [109.18363801, -0.17128868],
                            [109.18362251, -0.17115394],
                            [109.1836072, -0.17101918],
                            [109.18359215, -0.17088438],
                            [109.1835771, -0.17074959],
                            [109.18356262, -0.17061474],
                            [109.18354856, -0.17047984],
                            [109.18353451, -0.17034494],
                            [109.18352059, -0.17021002],
                            [109.18350743, -0.17007503],
                            [109.18349451, -0.16994002],
                            [109.18348277, -0.16980489],
                            [109.18347104, -0.16966976],
                            [109.18346022, -0.16953456],
                            [109.18345016, -0.1693993],
                            [109.18344011, -0.16926404],
                            [109.18343175, -0.16912866],
                            [109.18342353, -0.16899327],
                            [109.18341578, -0.16885786],
                            [109.18340947, -0.16872237],
                            [109.18340316, -0.16858687],
                            [109.18339773, -0.16845135],
                            [109.18339328, -0.16831578],
                            [109.18338882, -0.16818021],
                            [109.18338532, -0.16804462],
                            [109.18338254, -0.16790901],
                            [109.18337977, -0.1677734],
                            [109.18337782, -0.16763777],
                            [109.18337658, -0.16750213],
                            [109.18337534, -0.1673665],
                            [109.18337469, -0.16723086],
                            [109.18337488, -0.16709522],
                            [109.18337507, -0.16695958],
                            [109.18337553, -0.16682394],
                            [109.18337709, -0.16668831],
                            [109.18337864, -0.16655268],
                            [109.1833802, -0.16641704],
                            [109.18338297, -0.16628143],
                            [109.18338585, -0.16614582],
                            [109.18338872, -0.16601021],
                            [109.18339238, -0.16587462],
                            [109.18339657, -0.16573905],
                            [109.18340075, -0.16560347],
                            [109.18340526, -0.16546791],
                            [109.18341076, -0.16533238],
                            [109.18341627, -0.16519685],
                            [109.18342176, -0.16506132],
                            [109.18342849, -0.16492585],
                            [109.18343534, -0.16479039],
                            [109.1834422, -0.16465492],
                            [109.18344987, -0.1645195],
                            [109.18345818, -0.16438412],
                            [109.18346649, -0.16424874],
                            [109.18347516, -0.16411338],
                            [109.18348502, -0.1639781],
                            [109.18349488, -0.16384283],
                            [109.18350474, -0.16370755],
                            [109.18351608, -0.16357239],
                            [109.18352758, -0.16343724],
                            [109.18353908, -0.1633021],
                            [109.18355157, -0.16316704],
                            [109.18356478, -0.16303206],
                            [109.183578, -0.16289707],
                            [109.18359162, -0.16276212],
                            [109.18360662, -0.16262733],
                            [109.18362162, -0.16249253],
                            [109.18363662, -0.16235773],
                            [109.18365321, -0.16222312],
                            [109.18367004, -0.16208854],
                            [109.18368688, -0.16195397],
                            [109.18370461, -0.16181951],
                            [109.18372332, -0.16168518],
                            [109.18374203, -0.16155086],
                            [109.18376085, -0.16141654],
                            [109.18378147, -0.1612825],
                            [109.1838021, -0.16114846],
                            [109.18382272, -0.16101442],
                            [109.1838445, -0.16088056],
                            [109.18386709, -0.16074684],
                            [109.18388968, -0.16061312],
                            [109.18391241, -0.16047942],
                            [109.183937, -0.16034606],
                            [109.18396175, -0.16021273],
                            [109.18398773, -0.16007963],
                            [109.1840137, -0.15994654],
                            [109.18403968, -0.15981344],
                            [109.18406566, -0.15968035],
                            [109.18409164, -0.15954725],
                            [109.18411965, -0.15941458],
                            [109.18414823, -0.15928202],
                            [109.1841768, -0.15914947],
                            [109.18420538, -0.15901691],
                            [109.18423586, -0.15888479],
                            [109.18426637, -0.15875267],
                            [109.18429688, -0.15862055],
                            [109.18432751, -0.15848847],
                            [109.18435988, -0.1583568],
                            [109.18439226, -0.15822513],
                            [109.18442463, -0.15809346],
                            [109.18445701, -0.1579618],
                            [109.18449116, -0.15783058],
                            [109.18452531, -0.15769937],
                            [109.18455946, -0.15756816],
                            [109.18459362, -0.15743695],
                            [109.18462905, -0.15730609],
                            [109.18466484, -0.15717532],
                            [109.18470063, -0.15704455],
                            [109.18473642, -0.15691378],
                            [109.18477275, -0.15678317],
                            [109.1848099, -0.15665278],
                            [109.18484705, -0.1565224],
                            [109.1848842, -0.15639202],
                            [109.18492135, -0.15626163],
                            [109.18495952, -0.15613155],
                            [109.18499778, -0.15600149],
                            [109.18503605, -0.15587144],
                            [109.18507431, -0.15574138],
                            [109.18511298, -0.15561145],
                            [109.18515219, -0.15548168],
                            [109.18519139, -0.15535191],
                            [109.1852306, -0.15522214],
                            [109.18526982, -0.15509237],
                            [109.18530984, -0.15496285],
                            [109.18534987, -0.15483333],
                            [109.18538989, -0.15470381],
                            [109.18542992, -0.1545743],
                            [109.18547049, -0.15444495],
                            [109.18551125, -0.15431566],
                            [109.185552, -0.15418638],
                            [109.18559276, -0.15405709],
                            [109.185634, -0.15392796],
                            [109.18567543, -0.15379889],
                            [109.18571686, -0.15366982],
                            [109.18575831, -0.15354076],
                            [109.18580039, -0.1534119],
                            [109.18584247, -0.15328305],
                            [109.18588455, -0.15315419],
                            [109.18592715, -0.15302551],
                            [109.18596991, -0.15289688],
                            [109.18601267, -0.15276825],
                            [109.18605611, -0.15263985],
                            [109.18609961, -0.15251148],
                            [109.18614348, -0.15238323],
                            [109.18618771, -0.1522551],
                            [109.18623224, -0.15212709],
                            [109.18627713, -0.15199919],
                            [109.18632231, -0.15187141],
                            [109.18636764, -0.15174367],
                            [109.18641305, -0.15161597],
                            [109.18645823, -0.15148818],
                            [109.18650308, -0.15136027],
                            [109.18654725, -0.15123213],
                            [109.18659058, -0.15110369],
                            [109.18663299, -0.15097495],
                            [109.18667532, -0.15084618],
                            [109.18671694, -0.15071717],
                            [109.18675811, -0.15058802],
                            [109.18679859, -0.15045864],
                            [109.18683893, -0.15032922],
                            [109.1868787, -0.15019963],
                            [109.18691834, -0.15006999],
                            [109.18695754, -0.14994021],
                            [109.18699662, -0.1498104],
                            [109.18703533, -0.14968048],
                            [109.18707395, -0.14955053],
                            [109.18711223, -0.14942048],
                            [109.1871505, -0.14929042],
                            [109.1871884, -0.14916026],
                            [109.1872263, -0.1490301],
                            [109.1872639, -0.14889984],
                            [109.18730143, -0.14876957],
                            [109.18733878, -0.14863925],
                            [109.18737595, -0.14850887],
                            [109.18741305, -0.14837847],
                            [109.18744984, -0.14824799],
                            [109.18748664, -0.1481175],
                            [109.18752312, -0.14798693],
                            [109.18755952, -0.14785633],
                            [109.18759575, -0.14772568],
                            [109.18763174, -0.14759497],
                            [109.18766771, -0.14746425],
                            [109.18770324, -0.14733341],
                            [109.18773878, -0.14720258],
                            [109.18777399, -0.14707165],
                            [109.18780903, -0.14694067],
                            [109.18784388, -0.14680965],
                            [109.18787837, -0.14667853],
                            [109.18791283, -0.1465474],
                            [109.1879467, -0.14641611],
                            [109.18798058, -0.14628483],
                            [109.18801395, -0.14615341],
                            [109.18804719, -0.14602196],
                            [109.1880801, -0.14589043],
                            [109.18811269, -0.14575882],
                            [109.18814519, -0.14562718],
                            [109.18817716, -0.14549542],
                            [109.18820914, -0.14536365],
                            [109.18824071, -0.14523179],
                            [109.18827213, -0.14509988],
                            [109.18830346, -0.14496796],
                            [109.18833438, -0.14483594],
                            [109.18836531, -0.14470392],
                            [109.18839604, -0.14457185],
                            [109.18842654, -0.14443973],
                            [109.18845704, -0.14430762],
                            [109.18848736, -0.14417545],
                            [109.18851752, -0.14404325],
                            [109.18854767, -0.14391105],
                            [109.18857771, -0.14377882],
                            [109.18860756, -0.14364655],
                            [109.18863741, -0.14351428],
                            [109.18866725, -0.14338201],
                            [109.18869682, -0.14324968],
                            [109.18872639, -0.14311734],
                            [109.18875597, -0.14298501],
                            [109.18878536, -0.14285263],
                            [109.18881465, -0.14272024],
                            [109.18884395, -0.14258784],
                            [109.18887317, -0.14245543],
                            [109.18890217, -0.14232297],
                            [109.18893117, -0.1421905],
                            [109.18896017, -0.14205804],
                            [109.18898887, -0.14192551],
                            [109.18901754, -0.14179298],
                            [109.18904621, -0.14166044],
                            [109.18907461, -0.14152785],
                            [109.18910288, -0.14139523],
                            [109.18913115, -0.1412626],
                            [109.18915907, -0.14112991],
                            [109.18918683, -0.14099718],
                            [109.18921458, -0.14086444],
                            [109.18924165, -0.14073157],
                            [109.18926867, -0.14059868],
                            [109.18929507, -0.14046567],
                            [109.18932075, -0.14033252],
                            [109.18934529, -0.14019914],
                            [109.18936983, -0.14006577],
                            [109.18939309, -0.13993218],
                            [109.18941481, -0.13979831],
                            [109.18943398, -0.13966406],
                            [109.18945195, -0.13952963],
                            [109.18946974, -0.13939518],
                            [109.18948503, -0.13926042],
                            [109.1894984, -0.13912544],
                            [109.18951059, -0.13899036],
                            [109.18952173, -0.13885519],
                            [109.1895318, -0.13871993],
                            [109.18954124, -0.13858462],
                            [109.18954985, -0.13844926],
                            [109.18955774, -0.13831385],
                            [109.18956524, -0.13817842],
                            [109.18957163, -0.13804293],
                            [109.18957802, -0.13790744],
                            [109.18958315, -0.1377719],
                            [109.18958801, -0.13763635],
                            [109.18959249, -0.13750078],
                            [109.18959578, -0.13736518],
                            [109.18959908, -0.13722958],
                            [109.1896015, -0.13709396],
                            [109.18960315, -0.13695833],
                            [109.1896048, -0.1368227],
                            [109.1896052, -0.13668706],
                            [109.18960511, -0.13655142],
                            [109.18960503, -0.13641578],
                            [109.18960343, -0.13628015],
                            [109.18960148, -0.13614452],
                            [109.18959953, -0.13600889],
                            [109.18959596, -0.1358733],
                            [109.18959208, -0.13573772],
                            [109.1895882, -0.13560213],
                            [109.18958291, -0.1354666],
                            [109.18957732, -0.13533107],
                            [109.18957173, -0.13519554],
                            [109.18956499, -0.13506008],
                            [109.18955794, -0.13492462],
                            [109.18955088, -0.13478916],
                            [109.18954287, -0.13465376],
                            [109.18953455, -0.13451838],
                            [109.18952623, -0.134383],
                            [109.18951705, -0.13424767],
                            [109.18950764, -0.13411236],
                            [109.18949823, -0.13397705],
                            [109.18948798, -0.1338418],
                            [109.18947762, -0.13370656],
                            [109.18946718, -0.13357133],
                            [109.18945601, -0.13343616],
                            [109.18944484, -0.13330098],
                            [109.18943335, -0.13316584],
                            [109.18942148, -0.13303072],
                            [109.18940961, -0.13289561],
                            [109.18939713, -0.13276055],
                            [109.18938464, -0.13262549],
                            [109.18937163, -0.13249048],
                            [109.18935839, -0.1323555],
                            [109.18934465, -0.13222057],
                            [109.18933051, -0.13208567],
                            [109.18931581, -0.13195084],
                            [109.18930065, -0.13181606],
                            [109.1892848, -0.13168136],
                            [109.18926854, -0.13154671],
                            [109.18925148, -0.13141217],
                            [109.18923413, -0.13127765],
                            [109.18921592, -0.13114326],
                            [109.18920822, -0.13108693],
                            [109.18919755, -0.13100888],
                            [109.18917838, -0.13087462],
                            [109.1891591, -0.13074037],
                            [109.18913918, -0.13060623],
                            [109.18911912, -0.1304721],
                            [109.18909849, -0.13033805],
                            [109.18907757, -0.13020406],
                            [109.18905624, -0.13007013],
                            [109.1890343, -0.1299363],
                            [109.18901226, -0.12980248],
                            [109.18898912, -0.12966886],
                            [109.18896597, -0.12953523],
                            [109.18894175, -0.1294018],
                            [109.18891715, -0.12926844],
                            [109.18889184, -0.12913522],
                            [109.18886546, -0.1290022],
                            [109.18883883, -0.12886924],
                            [109.18881025, -0.12873668],
                            [109.18878167, -0.12860413],
                            [109.1887505, -0.12847217],
                            [109.18871912, -0.12834026],
                            [109.18868468, -0.12820913],
                            [109.18864973, -0.12807813],
                            [109.18861088, -0.12794826],
                            [109.18857107, -0.12781868],
                            [109.18852744, -0.12769035],
                            [109.18848158, -0.12756283],
                            [109.18843324, -0.12743622],
                            [109.18838091, -0.12731124],
                            [109.18832672, -0.12718707],
                            [109.18826941, -0.12706431],
                            [109.18820946, -0.12694285],
                            [109.1881481, -0.1268221],
                            [109.18808403, -0.12670277],
                            [109.18801895, -0.12658401],
                            [109.18795263, -0.12646594],
                            [109.18788514, -0.12634855],
                            [109.18781719, -0.12623142],
                            [109.18774819, -0.12611492],
                            [109.18767907, -0.12599848],
                            [109.18760925, -0.12588248],
                            [109.1875394, -0.12576649],
                            [109.18746922, -0.1256507],
                            [109.18739904, -0.12553491],
                            [109.18732883, -0.12541914],
                            [109.18725864, -0.12530336],
                            [109.18718872, -0.12518742],
                            [109.1871188, -0.12507147],
                            [109.18704942, -0.12495519],
                            [109.18698007, -0.1248389],
                            [109.18691139, -0.1247222],
                            [109.18684287, -0.12460541],
                            [109.18677493, -0.12448828],
                            [109.18670729, -0.12437097],
                            [109.18664008, -0.12425341],
                            [109.18657337, -0.12413557],
                            [109.18650687, -0.1240176],
                            [109.18644109, -0.12389922],
                            [109.18637532, -0.12378084],
                            [109.18631046, -0.12366195],
                            [109.18624564, -0.12354304],
                            [109.18618144, -0.12342379],
                            [109.18611758, -0.12330435],
                            [109.186054, -0.12318476],
                            [109.18599111, -0.1230648],
                            [109.18592823, -0.12294484],
                            [109.18586618, -0.12282444],
                            [109.18580426, -0.12270397],
                            [109.18574273, -0.1225833],
                            [109.1856818, -0.12246232],
                            [109.18562088, -0.12234134],
                            [109.18556089, -0.12221988],
                            [109.18550106, -0.12209835],
                            [109.18544156, -0.12197665],
                            [109.18538295, -0.12185452],
                            [109.18532434, -0.12173238],
                            [109.18526658, -0.12160984],
                            [109.18520932, -0.12148706],
                            [109.18518918, -0.12144386],
                            [109.18515206, -0.12136428],
                            [109.18509618, -0.12124085],
                            [109.18504039, -0.12111739],
                            [109.18498491, -0.12099378],
                            [109.18493071, -0.1208696],
                            [109.18487652, -0.12074541],
                            [109.18482301, -0.12062093],
                            [109.18477054, -0.120496],
                            [109.18471807, -0.12037107],
                            [109.18466663, -0.1202457],
                            [109.184616, -0.12012],
                            [109.18456537, -0.1199943],
                            [109.18451608, -0.11986807],
                            [109.1844674, -0.11974159],
                            [109.18441871, -0.11961512],
                            [109.18437153, -0.11948807],
                            [109.18432481, -0.11936084],
                            [109.18427809, -0.11923362],
                            [109.18423291, -0.11910583],
                            [109.18418813, -0.1189779],
                            [109.18414335, -0.11884997],
                            [109.18410003, -0.11872154],
                            [109.18405715, -0.11859295],
                            [109.18401426, -0.11846436],
                            [109.18397263, -0.11833536],
                            [109.1839316, -0.11820616],
                            [109.18389057, -0.11807696],
                            [109.18385044, -0.11794748],
                            [109.1838112, -0.11781772],
                            [109.18377196, -0.11768796],
                            [109.18373315, -0.11755807],
                            [109.18369563, -0.1174278],
                            [109.1836581, -0.11729752],
                            [109.18362058, -0.11716725],
                            [109.18358454, -0.11703655],
                            [109.18354865, -0.11690581],
                            [109.18351277, -0.11677507],
                            [109.1834776, -0.11664413],
                            [109.18344325, -0.11651297],
                            [109.18340891, -0.11638181],
                            [109.18337456, -0.11625065],
                            [109.18334152, -0.11611915],
                            [109.1833086, -0.11598762],
                            [109.18327568, -0.11585609],
                            [109.18324313, -0.11572447],
                            [109.18321154, -0.11559261],
                            [109.18317994, -0.11546075],
                            [109.18314834, -0.11532889],
                            [109.1831175, -0.11519686],
                            [109.18308716, -0.1150647],
                            [109.18305683, -0.11493254],
                            [109.18302649, -0.11480038],
                            [109.18299722, -0.11466798],
                            [109.18296811, -0.11453555],
                            [109.18293899, -0.11440311],
                            [109.18291005, -0.11427064],
                            [109.18288215, -0.11413794],
                            [109.18285424, -0.11400524],
                            [109.18282634, -0.11387254],
                            [109.18279896, -0.11373973],
                            [109.18277228, -0.11360677],
                            [109.1827456, -0.11347382],
                            [109.18271892, -0.11334086],
                            [109.1826932, -0.11320772],
                            [109.18266778, -0.11307451],
                            [109.18264235, -0.11294131],
                            [109.18261715, -0.11280806],
                            [109.18259303, -0.11267461],
                            [109.18256892, -0.11254116],
                            [109.1825448, -0.11240771],
                            [109.18252152, -0.11227411],
                            [109.18249866, -0.11214044],
                            [109.18247581, -0.11200676],
                            [109.18245323, -0.11187304],
                            [109.18243156, -0.11173916],
                            [109.18240989, -0.11160529],
                            [109.18238822, -0.11147141],
                            [109.18236751, -0.11133739],
                            [109.18234692, -0.11120334],
                            [109.18232634, -0.11106929],
                            [109.18230631, -0.11093516],
                            [109.1822867, -0.11080096],
                            [109.18226708, -0.11066676],
                            [109.18224774, -0.11053253],
                            [109.18222896, -0.11039821],
                            [109.18221017, -0.1102639],
                            [109.18219148, -0.11012957],
                            [109.18217338, -0.10999516],
                            [109.18215528, -0.10986074],
                            [109.18213719, -0.10972633],
                            [109.18211959, -0.10959185],
                            [109.18210202, -0.10945737],
                            [109.18208445, -0.10932289],
                            [109.18206719, -0.10918836],
                            [109.18205003, -0.10905383],
                            [109.18203286, -0.10891929],
                            [109.18201595, -0.10878473],
                            [109.18199922, -0.10865013],
                            [109.18198248, -0.10851554],
                            [109.18196598, -0.10838092],
                            [109.18194975, -0.10824627],
                            [109.18193352, -0.10811162],
                            [109.18191751, -0.10797694],
                            [109.18190189, -0.10784221],
                            [109.18188626, -0.10770749],
                            [109.18187086, -0.10757273],
                            [109.18185595, -0.10743793],
                            [109.18184104, -0.10730312],
                            [109.18182645, -0.10716828],
                            [109.18181239, -0.10703338],
                            [109.18179833, -0.10689848],
                            [109.18178483, -0.10676352],
                            [109.1817718, -0.10662851],
                            [109.18175877, -0.10649351],
                            [109.18174679, -0.1063584],
                            [109.18173502, -0.10622328],
                            [109.18172368, -0.10608813],
                            [109.18171347, -0.10595287],
                            [109.18170326, -0.10581762],
                            [109.18169475, -0.10568225],
                            [109.18168644, -0.10554687],
                            [109.18167947, -0.10541142],
                            [109.18167333, -0.10527592],
                            [109.18166817, -0.10514038],
                            [109.18166434, -0.1050048],
                            [109.18166109, -0.1048692],
                            [109.18165956, -0.10473357],
                            [109.18165814, -0.10459793],
                            [109.18165875, -0.10446229],
                            [109.18165936, -0.10432665],
                            [109.18166139, -0.10419103],
                            [109.18166386, -0.10405541],
                            [109.18166686, -0.10391981],
                            [109.18167084, -0.10378422],
                            [109.18167481, -0.10364864],
                            [109.18167969, -0.10351309],
                            [109.18168484, -0.10337755],
                            [109.18169, -0.10324201],
                            [109.18169609, -0.10310651],
                            [109.18170224, -0.10297101],
                            [109.18170839, -0.10283551],
                            [109.18171539, -0.10270005],
                            [109.18172244, -0.10256459],
                            [109.18172948, -0.10242914],
                            [109.1817372, -0.10229372],
                            [109.1817451, -0.10215831],
                            [109.18175299, -0.10202291],
                            [109.18176132, -0.10188753],
                            [109.18177005, -0.10175217],
                            [109.18177878, -0.10161681],
                            [109.18178765, -0.10148147],
                            [109.18179722, -0.10134617],
                            [109.18180679, -0.10121087],
                            [109.18181636, -0.10107557],
                            [109.18182663, -0.10094033],
                            [109.18183708, -0.10080509],
                            [109.18184754, -0.10066986],
                            [109.18185837, -0.10053466],
                            [109.18186978, -0.10039951],
                            [109.18188119, -0.10026435],
                            [109.18189263, -0.1001292],
                            [109.18190506, -0.09999414],
                            [109.18191749, -0.09985908],
                            [109.18192992, -0.09972402],
                            [109.18194305, -0.09958902],
                            [109.18195642, -0.09945405],
                            [109.18196979, -0.09931908],
                            [109.18198363, -0.09918415],
                            [109.18199785, -0.09904927],
                            [109.18201206, -0.09891439],
                            [109.18202666, -0.09877955],
                            [109.18204163, -0.09864474],
                            [109.1820566, -0.09850994],
                            [109.18207199, -0.09837519],
                            [109.18208764, -0.09824047],
                            [109.18210329, -0.09810575],
                            [109.18211951, -0.09797109],
                            [109.18213577, -0.09783644],
                            [109.18215228, -0.09770182],
                            [109.1821691, -0.09756724],
                            [109.18218602, -0.09743268],
                            [109.18220332, -0.09729816],
                            [109.18222077, -0.09716366],
                            [109.18223855, -0.0970292],
                            [109.18225682, -0.09689482],
                            [109.18227573, -0.09676052],
                            [109.18229589, -0.09662641],
                            [109.18231856, -0.09649271],
                            [109.18234693, -0.09636015],
                            [109.18234966, -0.09635208],
                            [109.18239023, -0.09623192],
                            [109.18246994, -0.09612332],
                            [109.18256875, -0.0960312],
                            [109.18267229, -0.09594444],
                            [109.18277773, -0.09586001],
                            [109.18288443, -0.09577718],
                            [109.1829916, -0.09569498],
                            [109.18309915, -0.09561328],
                            [109.18320689, -0.09553183],
                            [109.1833149, -0.09545074],
                            [109.1834229, -0.09536965],
                            [109.18353111, -0.09528883],
                            [109.18363937, -0.09520809],
                            [109.18374763, -0.09512734],
                            [109.18385601, -0.09504676],
                            [109.18396443, -0.09496624],
                            [109.18405742, -0.09489718],
                            [109.18463185, -0.09528675],
                            [109.18475511, -0.09539126],
                            [109.18507495, -0.09559828],
                            [109.1859431, -0.09582833],
                            [109.18703972, -0.0961619],
                            [109.1877251, -0.09632294],
                            [109.18810207, -0.09640346],
                            [109.18860469, -0.09634598],
                            [109.18917586, -0.09625401],
                            [109.18976987, -0.09620804],
                            [109.19064849, -0.09612089],
                            [109.19124542, -0.09616395],
                            [109.19192716, -0.09621313],
                            [109.19288102, -0.09635917],
                            [109.19307608, -0.09639986],
                            [109.19323636, -0.09640854],
                            [109.19352665, -0.09643234],
                            [109.19404079, -0.09642958],
                            [109.19604397, -0.09645613],
                            [109.19676376, -0.09649777],
                            [109.19750139, -0.09653941],
                            [109.19824814, -0.09660167],
                            [109.19863005, -0.09672302],
                            [109.19918756, -0.09699321],
                            [109.1998657, -0.09733585],
                            [109.20057002, -0.09778557],
                            [109.2017312, -0.09860411],
                            [109.20246407, -0.09920373],
                            [109.20296852, -0.09975577],
                            [109.20329213, -0.100146],
                            [109.20353959, -0.10065996],
                            [109.2037585, -0.10127862],
                            [109.20397741, -0.10218282],
                            [109.20431053, -0.10361049],
                            [109.20466269, -0.10474312],
                            [109.20549332, -0.10635473],
                            [109.20600031, -0.10699169],
                            [109.20697327, -0.10832823],
                            [109.20745797, -0.10913844],
                            [109.20803618, -0.1104519],
                            [109.20836454, -0.11121571],
                            [109.20865722, -0.11167971],
                            [109.2089713, -0.11191527],
                            [109.21018483, -0.1125149],
                            [109.21131269, -0.11296461],
                            [109.21197656, -0.11314307],
                            [109.21266185, -0.11325729],
                            [109.21317581, -0.11325729],
                            [109.21372547, -0.11314307],
                            [109.21425199, -0.11289985],
                            [109.21502787, -0.11241949],
                            [109.21563934, -0.11240926],
                            [109.21575789, -0.11242306],
                            [109.21603179, -0.11253352],
                            [109.21624821, -0.11269809],
                            [109.21639136, -0.11285928],
                            [109.21643376, -0.11291008],
                        ],
                    ],
                ],
            },
        };

        var batasPunggurKecil = {
            type: "Feature",
            properties: {
                popPupContent: "Desa Punggur Kecil",
                nama_desa: "Desa Pungur Kecil",
                batas: "Timur",
                style: {
                    weight: 2,
                    color: "white",
                    dashArray: '3',
                    opacity: 1,
                    fillColor: "#DC3535",
                    fillOpacity: 0.8,
                },
            },
            geometry: {
                type: "MultiPolygon",
                coordinates: [
                    [
                        [
                            [109.32937417, -0.09510513],
                            [109.32825951, -0.09631927],
                            [109.32504185, -0.09994031],
                            [109.33432175, -0.10850637],
                            [109.33822619, -0.10761834],
                            [109.34273307, -0.11163231],
                            [109.34476615, -0.11344303],
                            [109.34852469, -0.11671883],
                            [109.35097797, -0.11885702],
                            [109.35157284, -0.12052265],
                            [109.35216903, -0.12409976],
                            [109.35252462, -0.12623335],
                            [109.35257615, -0.12733257],
                            [109.35251234, -0.12905456],
                            [109.3611342, -0.13197433],
                            [109.36176784, -0.13352525],
                            [109.36177254, -0.13353677],
                            [109.36252125, -0.13536933],
                            [109.36323138, -0.14073534],
                            [109.36312081, -0.14139876],
                            [109.3618037, -0.1493014],
                            [109.36406419, -0.14906345],
                            [109.35958863, -0.16527087],
                            [109.35236608, -0.16209927],
                            [109.34738906, -0.15920007],
                            [109.34360773, -0.16461594],
                            [109.33450436, -0.17765436],
                            [109.319105, -0.1522148],
                            [109.31873514, -0.18422025],
                            [109.31869652, -0.18505219],
                            [109.30657282, -0.18160651],
                            [109.28200562, -0.20162551],
                            [109.28194374, -0.20168309],
                            [109.28190472, -0.20171008],
                            [109.28180314, -0.20178033],
                            [109.28168093, -0.20190254],
                            [109.28149761, -0.2020655],
                            [109.27696266, -0.19687396],
                            [109.27006222, -0.19078254],
                            [109.26673098, -0.18797478],
                            [109.26415326, -0.18602465],
                            [109.26361074, -0.18555828],
                            [109.26318243, -0.1851157],
                            [109.2628969, -0.18472546],
                            [109.26262564, -0.1842924],
                            [109.26205457, -0.18303605],
                            [109.26153595, -0.18170744],
                            [109.26121712, -0.17969343],
                            [109.2609822, -0.17719106],
                            [109.26041113, -0.17273671],
                            [109.26004945, -0.16927221],
                            [109.25995427, -0.16828236],
                            [109.25995427, -0.1672925],
                            [109.25996094, -0.16634159],
                            [109.26010371, -0.16557778],
                            [109.26044635, -0.16376463],
                            [109.26081755, -0.16212994],
                            [109.26113853, -0.16083763],
                            [109.26128725, -0.16007987],
                            [109.26166791, -0.15856924],
                            [109.26168955, -0.15842165],
                            [109.26190335, -0.15729339],
                            [109.26195618, -0.15689649],
                            [109.26200789, -0.15640805],
                            [109.26204234, -0.154113],
                            [109.26208605, -0.15315615],
                            [109.2621512, -0.15218863],
                            [109.26220345, -0.15058599],
                            [109.26221723, -0.15028445],
                            [109.26226996, -0.14948967],
                            [109.26233339, -0.14906654],
                            [109.2623548, -0.14871676],
                            [109.26235004, -0.14812666],
                            [109.26232863, -0.14765076],
                            [109.26226409, -0.14700758],
                            [109.26218983, -0.14600323],
                            [109.26214385, -0.14434666],
                            [109.26222227, -0.14243459],
                            [109.26227417, -0.14010557],
                            [109.26243756, -0.13713898],
                            [109.26253944, -0.13530288],
                            [109.26258152, -0.13451921],
                            [109.26257934, -0.13410036],
                            [109.26099224, -0.13362338],
                            [109.25977396, -0.1332617],
                            [109.2578228, -0.13255738],
                            [109.25599537, -0.1316627],
                            [109.25354929, -0.13056815],
                            [109.25096043, -0.12940697],
                            [109.24991372, -0.12892089],
                            [109.2497037, -0.12885152],
                            [109.2493801, -0.12877157],
                            [109.24896702, -0.1286859],
                            [109.24859374, -0.12860339],
                            [109.24844536, -0.12856875],
                            [109.24793478, -0.12846374],
                            [109.24770826, -0.12841044],
                            [109.24747473, -0.12831195],
                            [109.24587232, -0.12743],
                            [109.24267039, -0.12550885],
                            [109.2423151, -0.12530213],
                            [109.24225665, -0.1252606],
                            [109.24181818, -0.12494905],
                            [109.24051676, -0.12399432],
                            [109.23973868, -0.12349463],
                            [109.23921283, -0.12324259],
                            [109.23873612, -0.1229905],
                            [109.23831122, -0.12290549],
                            [109.23788767, -0.12286266],
                            [109.23769732, -0.12289597],
                            [109.23754027, -0.12295784],
                            [109.23749249, -0.12306751],
                            [109.23735848, -0.12337383],
                            [109.2371616, -0.1237203],
                            [109.23707548, -0.12376812],
                            [109.23694985, -0.12378716],
                            [109.23684515, -0.12378526],
                            [109.2364416, -0.1235968],
                            [109.2360381, -0.12339661],
                            [109.23585726, -0.12337758],
                            [109.23568594, -0.12340137],
                            [109.23505194, -0.12366606],
                            [109.23426176, -0.12389547],
                            [109.23381213, -0.1239262],
                            [109.23348702, -0.1238957],
                            [109.23312713, -0.12378565],
                            [109.23292785, -0.12372022],
                            [109.23279103, -0.12372022],
                            [109.23271667, -0.12373806],
                            [109.23257391, -0.12386001],
                            [109.23228299, -0.12410126],
                            [109.23216047, -0.12419611],
                            [109.23203258, -0.12422883],
                            [109.23184222, -0.12420206],
                            [109.23163699, -0.12411283],
                            [109.23124736, -0.12380945],
                            [109.23091126, -0.12357448],
                            [109.23044429, -0.12337817],
                            [109.2302846, -0.12335401],
                            [109.23007521, -0.12335401],
                            [109.22988218, -0.12337456],
                            [109.22907774, -0.12348444],
                            [109.22868817, -0.12345235],
                            [109.22823988, -0.1233348],
                            [109.22720948, -0.12299963],
                            [109.22660034, -0.12281308],
                            [109.22600642, -0.12263224],
                            [109.22576276, -0.1225561],
                            [109.22553243, -0.122499],
                            [109.22532304, -0.12243427],
                            [109.22516695, -0.12236955],
                            [109.22506013, -0.12232147],
                            [109.22499112, -0.1222489],
                            [109.22491587, -0.12214459],
                            [109.22460739, -0.12177887],
                            [109.22446072, -0.12166714],
                            [109.22427988, -0.1215434],
                            [109.22381732, -0.12131307],
                            [109.22317097, -0.12098226],
                            [109.22283368, -0.12078359],
                            [109.22251671, -0.12063888],
                            [109.22181508, -0.12031857],
                            [109.22077443, -0.11970942],
                            [109.21898873, -0.11873843],
                            [109.21763683, -0.11831597],
                            [109.21760129, -0.11811387],
                            [109.21756362, -0.11779967],
                            [109.21750388, -0.11735218],
                            [109.21740469, -0.11678634],
                            [109.21738548, -0.11668731],
                            [109.21721521, -0.11543865],
                            [109.21711889, -0.11501556],
                            [109.2170609, -0.11472587],
                            [109.2169448, -0.11417694],
                            [109.21692795, -0.11412866],
                            [109.21659293, -0.113169],
                            [109.21655931, -0.11307907],
                            [109.21651648, -0.11300919],
                            [109.21643376, -0.11291008],
                            [109.2164912, -0.11290485],
                            [109.21649434, -0.11290757],
                            [109.21675498, -0.11297642],
                            [109.21695633, -0.11294765],
                            [109.21699729, -0.11296115],
                            [109.21704768, -0.11299448],
                            [109.21722671, -0.11328132],
                            [109.21736449, -0.11346104],
                            [109.21748849, -0.11363238],
                            [109.21772189, -0.11396953],
                            [109.21772236, -0.1139702],
                            [109.2179, -0.11412871],
                            [109.21800388, -0.1142214],
                            [109.21817279, -0.11437732],
                            [109.21818589, -0.11439357],
                            [109.21840162, -0.11466124],
                            [109.21840666, -0.11466749],
                            [109.21847596, -0.11474545],
                            [109.21855392, -0.11477577],
                            [109.21865732, -0.11478139],
                            [109.21872649, -0.11468574],
                            [109.21872716, -0.11468482],
                            [109.21873415, -0.11468031],
                            [109.21911695, -0.11443362],
                            [109.21928134, -0.11433804],
                            [109.21934791, -0.1143214],
                            [109.21944568, -0.11431277],
                            [109.21960954, -0.11435374],
                            [109.21970456, -0.11452915],
                            [109.2197265, -0.11462851],
                            [109.21977526, -0.1148494],
                            [109.21979259, -0.11491003],
                            [109.21990519, -0.11501831],
                            [109.21991627, -0.11504878],
                            [109.21996244, -0.11507186],
                            [109.21998988, -0.11507593],
                            [109.22009827, -0.11505425],
                            [109.22028562, -0.11481803],
                            [109.22029558, -0.11480927],
                            [109.22048926, -0.11463883],
                            [109.22053344, -0.11459641],
                            [109.22091865, -0.11426038],
                            [109.22107457, -0.11430802],
                            [109.22117418, -0.11445527],
                            [109.2212224, -0.11459993],
                            [109.22127123, -0.11480988],
                            [109.22128089, -0.11484309],
                            [109.22137527, -0.11516726],
                            [109.22139196, -0.11522458],
                            [109.22145238, -0.11543211],
                            [109.22145857, -0.11545338],
                            [109.22147754, -0.11547099],
                            [109.22157261, -0.11555927],
                            [109.22166754, -0.11552018],
                            [109.22175139, -0.11544986],
                            [109.22178052, -0.11542542],
                            [109.22195924, -0.11518287],
                            [109.22211836, -0.11511127],
                            [109.22213373, -0.11511785],
                            [109.22218493, -0.11515768],
                            [109.22233829, -0.1155104],
                            [109.22263153, -0.11583622],
                            [109.22267214, -0.11585314],
                            [109.22291994, -0.11595639],
                            [109.22293903, -0.11595269],
                            [109.22304695, -0.11590953],
                            [109.2231095, -0.11584051],
                            [109.22328317, -0.11564887],
                            [109.22335377, -0.1156339],
                            [109.22354758, -0.11558134],
                            [109.22375473, -0.11562784],
                            [109.2237598, -0.11562898],
                            [109.22376697, -0.11563167],
                            [109.2237719, -0.11563258],
                            [109.22379435, -0.11564194],
                            [109.22396739, -0.11571404],
                            [109.22433394, -0.11600728],
                            [109.22450149, -0.11608547],
                            [109.22453505, -0.11610539],
                            [109.22454169, -0.11610423],
                            [109.22470829, -0.11607507],
                            [109.22489973, -0.11600737],
                            [109.22505828, -0.1159513],
                            [109.22517102, -0.11602645],
                            [109.22530605, -0.1161962],
                            [109.22552209, -0.11624636],
                            [109.22553704, -0.11624332],
                            [109.225769, -0.1161962],
                            [109.22577589, -0.11619776],
                            [109.22596472, -0.11623908],
                            [109.22605716, -0.1162593],
                            [109.22635841, -0.1164692],
                            [109.22645802, -0.11632194],
                            [109.22645806, -0.11632193],
                            [109.22645957, -0.11631966],
                            [109.22649204, -0.11631303],
                            [109.2266479, -0.11628122],
                            [109.22667294, -0.11630297],
                            [109.22680293, -0.11641996],
                            [109.22697654, -0.11666687],
                            [109.22697674, -0.11666698],
                            [109.22707684, -0.11671703],
                            [109.22724416, -0.11659154],
                            [109.22732375, -0.11653184],
                            [109.22746264, -0.11649326],
                            [109.22752856, -0.11651661],
                            [109.22764782, -0.11655885],
                            [109.22793309, -0.11647433],
                            [109.22803018, -0.11644754],
                            [109.22811304, -0.11642325],
                            [109.22828138, -0.11637391],
                            [109.22848927, -0.11639124],
                            [109.22863652, -0.11650384],
                            [109.22869685, -0.11652797],
                            [109.22870149, -0.11652983],
                            [109.22873446, -0.11650827],
                            [109.22882304, -0.11645036],
                            [109.22885226, -0.11643126],
                            [109.22893103, -0.11615736],
                            [109.22900169, -0.11612492],
                            [109.22916491, -0.11621367],
                            [109.22927305, -0.11614453],
                            [109.22935666, -0.11602292],
                            [109.22939875, -0.1159569],
                            [109.22939161, -0.11590686],
                            [109.22941177, -0.1158991],
                            [109.22941177, -0.1158975],
                            [109.22950437, -0.11586046],
                            [109.22953304, -0.11588451],
                            [109.22961521, -0.11588077],
                            [109.22962832, -0.11588018],
                            [109.22963688, -0.11587886],
                            [109.22966938, -0.11587599],
                            [109.22989699, -0.11593001],
                            [109.22993557, -0.11591072],
                            [109.2299794, -0.11588527],
                            [109.22998609, -0.11588271],
                            [109.22999106, -0.1158785],
                            [109.23005517, -0.11584127],
                            [109.23011574, -0.11574706],
                            [109.23016104, -0.11568528],
                            [109.2302624, -0.11561771],
                            [109.23038192, -0.11553803],
                            [109.23043923, -0.11551614],
                            [109.23058379, -0.1154569],
                            [109.23064786, -0.11543064],
                            [109.23065315, -0.11542847],
                            [109.23086175, -0.11530619],
                            [109.23115416, -0.11521968],
                            [109.23116626, -0.11521629],
                            [109.23132057, -0.11523172],
                            [109.23136454, -0.11519508],
                            [109.23149499, -0.11510926],
                            [109.23152531, -0.11505728],
                            [109.23169175, -0.11501217],
                            [109.23169792, -0.11500813],
                            [109.23169865, -0.11500796],
                            [109.23170557, -0.11500313],
                            [109.23190312, -0.11486522],
                            [109.23200863, -0.11479831],
                            [109.23203637, -0.11477577],
                            [109.23204463, -0.11477548],
                            [109.23277264, -0.11474978],
                            [109.23277313, -0.11474952],
                            [109.23277502, -0.11474948],
                            [109.23278698, -0.114742],
                            [109.23287554, -0.11469392],
                            [109.23297674, -0.11464965],
                            [109.23306318, -0.11462027],
                            [109.23306613, -0.11461927],
                            [109.23309852, -0.11460826],
                            [109.23320875, -0.11458295],
                            [109.23331488, -0.11448917],
                            [109.23349938, -0.11432612],
                            [109.23356785, -0.11433264],
                            [109.23356991, -0.11433292],
                            [109.23365561, -0.11438746],
                            [109.23373257, -0.11444005],
                            [109.23374705, -0.11444241],
                            [109.23384385, -0.11445816],
                            [109.23387407, -0.11444616],
                            [109.23390539, -0.11442155],
                            [109.23394125, -0.11425606],
                            [109.23395554, -0.11419008],
                            [109.23400434, -0.11413884],
                            [109.2340352, -0.11410894],
                            [109.23403536, -0.11410879],
                            [109.2343485, -0.11409067],
                            [109.23441891, -0.11407103],
                            [109.23446231, -0.11405892],
                            [109.2345221, -0.11404224],
                            [109.2345551, -0.11399856],
                            [109.23461564, -0.11392793],
                            [109.23473669, -0.11382929],
                            [109.23479792, -0.11380662],
                            [109.23485444, -0.11378885],
                            [109.23527882, -0.11364225],
                            [109.23543518, -0.11358499],
                            [109.23556579, -0.1135411],
                            [109.23557511, -0.11353797],
                            [109.23621006, -0.11349713],
                            [109.24091641, -0.11299697],
                            [109.2415554, -0.11294946],
                            [109.24191733, -0.11294946],
                            [109.24967557, -0.1120661],
                            [109.25052355, -0.11196955],
                            [109.25336824, -0.11128277],
                            [109.25403686, -0.11113996],
                            [109.25612959, -0.10980061],
                            [109.25799916, -0.10843066],
                            [109.26220147, -0.10543164],
                            [109.26444731, -0.10379383],
                            [109.26705997, -0.10190502],
                            [109.26818313, -0.10111824],
                            [109.26928485, -0.10029242],
                            [109.27513157, -0.09613508],
                            [109.27734417, -0.09556286],
                            [109.27755914, -0.09550726],
                            [109.27879509, -0.09524242],
                            [109.29631, -0.09148922],
                            [109.29618591, -0.0907199],
                            [109.29610073, -0.09019173],
                            [109.2968542, -0.08751542],
                            [109.29760987, -0.08751542],
                            [109.30794796, -0.08814323],
                            [109.31305422, -0.08851993],
                            [109.31832852, -0.0892507],
                            [109.3221828, -0.08975576],
                            [109.32220895, -0.08975919],
                            [109.321944, -0.094167],
                            [109.32254088, -0.09428638],
                            [109.32323093, -0.09450053],
                            [109.32472999, -0.09476227],
                            [109.32544382, -0.09492883],
                            [109.32615766, -0.0950716],
                            [109.32684771, -0.09511919],
                            [109.32801364, -0.09526196],
                            [109.32937417, -0.09510513],
                        ],
                    ],
                ],
            },
        };

        var batasPalSembilan = {
            type: "Feature",
            properties: {
                popPupContent: "Desa Pal Sembilan",
                nama_desa: "Desa Pal Sembilan",
                batas: "Utara",
                style: {
                    weight: 2,
                    color: "white",
                    dashArray: '3',
                    opacity: 1,
                    fillColor: "#EA047E",
                    fillOpacity: 0.8,
                },
            },
            geometry: {
                type: "MultiPolygon",
                coordinates: [
                    [
                        [
                            [109.28282875, -0.04291465],
                            [109.28327133, -0.04244351],
                            [109.28369963, -0.04204377],
                            [109.28420225, -0.04158707],
                            [109.28428791, -0.04169178],
                            [109.284764, -0.041069],
                            [109.28501309, -0.04142986],
                            [109.28534146, -0.04180106],
                            [109.28589825, -0.04241496],
                            [109.28622662, -0.04285754],
                            [109.28675486, -0.0435],
                            [109.28704676, -0.04371274],
                            [109.28896937, -0.04557824],
                            [109.29013055, -0.04677748],
                            [109.29155822, -0.04843359],
                            [109.29336661, -0.05016584],
                            [109.2943755, -0.05132701],
                            [109.29549861, -0.05248819],
                            [109.29616486, -0.05321155],
                            [109.29679304, -0.05391587],
                            [109.29780193, -0.05490572],
                            [109.29900118, -0.05621919],
                            [109.30080957, -0.05827504],
                            [109.30271314, -0.06040704],
                            [109.30318903, -0.06086389],
                            [109.30307891, -0.06096619],
                            [109.30322168, -0.06112324],
                            [109.30312174, -0.06129456],
                            [109.30387841, -0.06202267],
                            [109.30451975, -0.06272208],
                            [109.30366492, -0.06354793],
                            [109.30404563, -0.06381443],
                            [109.30467381, -0.06427128],
                            [109.30528295, -0.06476621],
                            [109.306178, -0.065423],
                            [109.30758627, -0.06646039],
                            [109.30705327, -0.06697435],
                            [109.30682484, -0.06735506],
                            [109.30655835, -0.06762156],
                            [109.305593, -0.068706],
                            [109.30494031, -0.06939188],
                            [109.30632992, -0.07074342],
                            [109.307874, -0.072173],
                            [109.30731977, -0.07365588],
                            [109.30684388, -0.07514066],
                            [109.30631088, -0.07618762],
                            [109.3056256, -0.07662544],
                            [109.30644413, -0.07748205],
                            [109.30688195, -0.07782469],
                            [109.310776, -0.079688],
                            [109.31169639, -0.08034454],
                            [109.31304793, -0.08125825],
                            [109.320278, -0.085278],
                            [109.3225, -0.088056],
                            [109.32220895, -0.08975919],
                            [109.3221828, -0.08975576],
                            [109.31832852, -0.0892507],
                            [109.31305422, -0.08851993],
                            [109.30794796, -0.08814323],
                            [109.29760987, -0.08751542],
                            [109.2968542, -0.08751542],
                            [109.29688391, -0.08740707],
                            [109.27810269, -0.08950746],
                            [109.27309609, -0.09006737],
                            [109.2697258, -0.09040011],
                            [109.26361018, -0.09105179],
                            [109.26359676, -0.0910052],
                            [109.26359605, -0.09100527],
                            [109.26034629, -0.07884555],
                            [109.26011173, -0.07796791],
                            [109.25915936, -0.07440439],
                            [109.25977915, -0.07433535],
                            [109.25976784, -0.07424153],
                            [109.26081771, -0.07407577],
                            [109.26033631, -0.07330187],
                            [109.25962204, -0.07209755],
                            [109.25746617, -0.06862695],
                            [109.2574114, -0.06853419],
                            [109.25671517, -0.0673761],
                            [109.25640581, -0.06691205],
                            [109.25639221, -0.06836105],
                            [109.2531021, -0.06920982],
                            [109.25138889, -0.06966668],
                            [109.25058939, -0.06979517],
                            [109.2488048, -0.06979517],
                            [109.24508575, -0.06992299],
                            [109.24211531, -0.07040695],
                            [109.23907595, -0.07090213],
                            [109.23743093, -0.07106526],
                            [109.23751773, -0.05804682],
                            [109.23757159, -0.04996941],
                            [109.23821856, -0.0435167],
                            [109.23712248, -0.03881803],
                            [109.24107578, -0.03969817],
                            [109.247006, -0.03933435],
                            [109.2507989, -0.03910448],
                            [109.25494129, -0.0387966],
                            [109.25930567, -0.03851632],
                            [109.26549884, -0.03403784],
                            [109.2661984, -0.03342394],
                            [109.26746903, -0.03211047],
                            [109.26881472, -0.02981254],
                            [109.26933999, -0.02971567],
                            [109.27212628, -0.02639299],
                            [109.27254283, -0.02710256],
                            [109.27317726, -0.0281833],
                            [109.27398442, -0.02955827],
                            [109.274168, -0.029871],
                            [109.27558797, -0.03288936],
                            [109.27701565, -0.03490238],
                            [109.27731554, -0.03547169],
                            [109.27779143, -0.03630451],
                            [109.27838629, -0.0369886],
                            [109.27862424, -0.03761321],
                            [109.27954628, -0.0391896],
                            [109.28083, -0.04118716],
                            [109.28159143, -0.04227219],
                            [109.28177227, -0.042434],
                            [109.28188648, -0.04229123],
                            [109.28249105, -0.04319623],
                            [109.28237752, -0.04332758],
                            [109.28282875, -0.04291465],
                        ],
                    ],
                ],
            },
        };

        var batasPunggurBesar = {
            type: "Feature",
            properties: {
                popPupContent: "Desa Punggur Besar",
                nama_desa: "Desa Pungur Besar",
                batas: "Tenggara",
                style: {
                    weight: 2,
                    color: "white",
                    dashArray: '3',
                    opacity: 1,
                    fillColor: "#645CAA",
                    fillOpacity: 0.8,
                },
            },
            geometry: {
                type: "MultiPolygon",
                coordinates: [
                    [
                        [
                            [109.28149761, -0.2020655],
                            [109.25381577, -0.23299427],
                            [109.25164683, -0.23134588],
                            [109.23978756, -0.25094886],
                            [109.23965663, -0.25107979],
                            [109.23923766, -0.25165587],
                            [109.23912495, -0.25175955],
                            [109.23716429, -0.25356328],
                            [109.23713669, -0.25354325],
                            [109.23706383, -0.25349036],
                            [109.23699097, -0.25343747],
                            [109.23691811, -0.25338458],
                            [109.23684525, -0.2533317],
                            [109.23677239, -0.25327881],
                            [109.23669952, -0.25322592],
                            [109.23662666, -0.25317303],
                            [109.2365538, -0.25312014],
                            [109.23648094, -0.25306725],
                            [109.23640808, -0.25301436],
                            [109.23633522, -0.25296147],
                            [109.23626236, -0.25290859],
                            [109.2361895, -0.2528557],
                            [109.23611664, -0.25280281],
                            [109.23604378, -0.25274992],
                            [109.23597092, -0.25269703],
                            [109.23589806, -0.25264414],
                            [109.2358252, -0.25259125],
                            [109.23575234, -0.25253836],
                            [109.23567948, -0.25248547],
                            [109.23560662, -0.25243259],
                            [109.23553376, -0.2523797],
                            [109.2354609, -0.25232681],
                            [109.23538803, -0.25227392],
                            [109.23531517, -0.25222103],
                            [109.23524231, -0.25216814],
                            [109.23516945, -0.25211525],
                            [109.23509659, -0.25206237],
                            [109.23502373, -0.25200948],
                            [109.23495087, -0.25195659],
                            [109.23487801, -0.2519037],
                            [109.23480515, -0.25185081],
                            [109.23473229, -0.25179792],
                            [109.23465943, -0.25174503],
                            [109.23458657, -0.25169214],
                            [109.23451371, -0.25163926],
                            [109.23444085, -0.25158637],
                            [109.23436799, -0.25153348],
                            [109.23429513, -0.25148059],
                            [109.23422227, -0.2514277],
                            [109.23414941, -0.25137481],
                            [109.23407655, -0.25132192],
                            [109.23400368, -0.25126903],
                            [109.23393004, -0.25121729],
                            [109.23385484, -0.25116783],
                            [109.23377965, -0.25111836],
                            [109.23370445, -0.2510689],
                            [109.23362926, -0.25101943],
                            [109.23355406, -0.25096997],
                            [109.23347887, -0.2509205],
                            [109.23340367, -0.25087104],
                            [109.23332847, -0.25082158],
                            [109.23325328, -0.25077211],
                            [109.23317808, -0.25072265],
                            [109.23310289, -0.25067318],
                            [109.23302769, -0.25062372],
                            [109.23295249, -0.25057425],
                            [109.2328773, -0.25052479],
                            [109.2328021, -0.25047532],
                            [109.23272691, -0.25042586],
                            [109.23265171, -0.25037639],
                            [109.23257651, -0.25032693],
                            [109.23250132, -0.25027746],
                            [109.23242612, -0.250228],
                            [109.23235093, -0.25017853],
                            [109.23227573, -0.25012907],
                            [109.23220053, -0.2500796],
                            [109.23212534, -0.25003014],
                            [109.23208128, -0.25],
                            [109.23205106, -0.24997933],
                            [109.23197822, -0.24992641],
                            [109.23190538, -0.2498735],
                            [109.23183254, -0.24982058],
                            [109.2317597, -0.24976767],
                            [109.23168685, -0.24971475],
                            [109.23161401, -0.24966184],
                            [109.23154117, -0.24960892],
                            [109.23146833, -0.24955601],
                            [109.23139549, -0.24950309],
                            [109.23132265, -0.24945018],
                            [109.23124981, -0.24939726],
                            [109.23117696, -0.24934434],
                            [109.23110412, -0.24929143],
                            [109.23103128, -0.24923852],
                            [109.23095844, -0.2491856],
                            [109.2308856, -0.24913269],
                            [109.23081276, -0.24907977],
                            [109.23073992, -0.24902686],
                            [109.23066707, -0.24897394],
                            [109.23059423, -0.24892103],
                            [109.23052139, -0.24886811],
                            [109.23044855, -0.2488152],
                            [109.23037571, -0.24876228],
                            [109.23030287, -0.24870937],
                            [109.23023002, -0.24865645],
                            [109.23015718, -0.24860354],
                            [109.23008434, -0.24855062],
                            [109.2300115, -0.24849771],
                            [109.22993866, -0.24844479],
                            [109.22986582, -0.24839188],
                            [109.22979298, -0.24833896],
                            [109.22972013, -0.24828605],
                            [109.22964729, -0.24823313],
                            [109.22957445, -0.24818022],
                            [109.22950161, -0.2481273],
                            [109.22942877, -0.24807439],
                            [109.22935593, -0.24802147],
                            [109.22928308, -0.24796856],
                            [109.22921024, -0.24791565],
                            [109.2291374, -0.24786273],
                            [109.22906456, -0.24780982],
                            [109.22899172, -0.2477569],
                            [109.22891888, -0.24770399],
                            [109.22884604, -0.24765107],
                            [109.2287732, -0.24759816],
                            [109.22870035, -0.24754524],
                            [109.22862751, -0.24749233],
                            [109.22855467, -0.24743941],
                            [109.22848183, -0.2473865],
                            [109.22840899, -0.24733358],
                            [109.22833615, -0.24728067],
                            [109.2282633, -0.24722775],
                            [109.22819046, -0.24717484],
                            [109.22811762, -0.24712192],
                            [109.22804478, -0.24706901],
                            [109.22797194, -0.24701609],
                            [109.2278991, -0.24696318],
                            [109.22782626, -0.24691026],
                            [109.22775341, -0.24685735],
                            [109.22768057, -0.24680443],
                            [109.22760773, -0.24675152],
                            [109.22753489, -0.2466986],
                            [109.22746205, -0.24664569],
                            [109.22738921, -0.24659278],
                            [109.22731637, -0.24653986],
                            [109.22724352, -0.24648695],
                            [109.22717068, -0.24643403],
                            [109.22709784, -0.24638112],
                            [109.227025, -0.2463282],
                            [109.22695216, -0.24627529],
                            [109.22687932, -0.24622237],
                            [109.22680648, -0.24616946],
                            [109.22673363, -0.24611654],
                            [109.22666079, -0.24606363],
                            [109.22658795, -0.24601071],
                            [109.22651511, -0.2459578],
                            [109.22644227, -0.24590488],
                            [109.22636943, -0.24585197],
                            [109.22629659, -0.24579906],
                            [109.22622374, -0.24574614],
                            [109.2261509, -0.24569323],
                            [109.22607806, -0.24564031],
                            [109.22600522, -0.2455874],
                            [109.22593238, -0.24553448],
                            [109.22585954, -0.24548157],
                            [109.2257867, -0.24542865],
                            [109.22571386, -0.24537574],
                            [109.22564101, -0.24532282],
                            [109.22556817, -0.24526991],
                            [109.22549533, -0.24521699],
                            [109.22542249, -0.24516408],
                            [109.22534965, -0.24511116],
                            [109.22527681, -0.24505825],
                            [109.22520397, -0.24500534],
                            [109.22513112, -0.24495242],
                            [109.22505828, -0.24489951],
                            [109.22498544, -0.24484659],
                            [109.2249126, -0.24479368],
                            [109.22483976, -0.24474076],
                            [109.22476692, -0.24468785],
                            [109.22469408, -0.24463493],
                            [109.22462123, -0.24458202],
                            [109.22454839, -0.2445291],
                            [109.22447555, -0.24447619],
                            [109.22440271, -0.24442327],
                            [109.22433354, -0.24436617],
                            [109.2242724, -0.24429992],
                            [109.22421126, -0.24423368],
                            [109.22415012, -0.24416743],
                            [109.22408899, -0.24410118],
                            [109.22402785, -0.24403493],
                            [109.22396671, -0.24396868],
                            [109.22390557, -0.24390243],
                            [109.22384443, -0.24383618],
                            [109.22378329, -0.24376993],
                            [109.22372215, -0.24370368],
                            [109.22366101, -0.24363743],
                            [109.22359987, -0.24357118],
                            [109.22353873, -0.24350493],
                            [109.22347759, -0.24343869],
                            [109.22341645, -0.24337244],
                            [109.22335531, -0.24330619],
                            [109.22329417, -0.24323994],
                            [109.22323303, -0.24317369],
                            [109.22317189, -0.24310744],
                            [109.22311075, -0.24304119],
                            [109.22304961, -0.24297494],
                            [109.22298847, -0.24290869],
                            [109.22292734, -0.24284244],
                            [109.2228662, -0.24277619],
                            [109.22280506, -0.24270995],
                            [109.22274392, -0.2426437],
                            [109.22268278, -0.24257745],
                            [109.22262164, -0.2425112],
                            [109.2225605, -0.24244495],
                            [109.22249936, -0.2423787],
                            [109.22243822, -0.24231245],
                            [109.22237708, -0.2422462],
                            [109.22231594, -0.24217995],
                            [109.2222548, -0.2421137],
                            [109.22219366, -0.24204746],
                            [109.22213252, -0.24198121],
                            [109.22207138, -0.24191496],
                            [109.22201024, -0.24184871],
                            [109.2219491, -0.24178246],
                            [109.22188796, -0.24171621],
                            [109.22182683, -0.24164996],
                            [109.22176569, -0.24158371],
                            [109.22170455, -0.24151746],
                            [109.22164341, -0.24145121],
                            [109.22158227, -0.24138496],
                            [109.22152113, -0.24131872],
                            [109.22145999, -0.24125247],
                            [109.22139885, -0.24118622],
                            [109.22133771, -0.24111997],
                            [109.22128732, -0.24104545],
                            [109.22123981, -0.2409687],
                            [109.22119231, -0.24089195],
                            [109.2211448, -0.2408152],
                            [109.2210973, -0.24073845],
                            [109.2210498, -0.2406617],
                            [109.22100229, -0.24058495],
                            [109.22095479, -0.2405082],
                            [109.22090729, -0.24043146],
                            [109.22085978, -0.24035471],
                            [109.22081228, -0.24027796],
                            [109.22076478, -0.24020121],
                            [109.22071727, -0.24012446],
                            [109.22066977, -0.24004771],
                            [109.22062227, -0.23997096],
                            [109.22057476, -0.23989421],
                            [109.22052726, -0.23981746],
                            [109.22047976, -0.23974072],
                            [109.22043225, -0.23966397],
                            [109.22038475, -0.23958722],
                            [109.22033725, -0.23951047],
                            [109.22028974, -0.23943372],
                            [109.22024224, -0.23935697],
                            [109.22019474, -0.23928022],
                            [109.22014723, -0.23920347],
                            [109.22009973, -0.23912673],
                            [109.22005222, -0.23904998],
                            [109.22000472, -0.23897323],
                            [109.21996498, -0.23889241],
                            [109.2199297, -0.23880925],
                            [109.21989441, -0.23872609],
                            [109.21985912, -0.23864293],
                            [109.21982384, -0.23855977],
                            [109.21978855, -0.23847661],
                            [109.21975327, -0.23839345],
                            [109.21971798, -0.23831029],
                            [109.2196827, -0.23822713],
                            [109.21964741, -0.23814397],
                            [109.21961213, -0.23806081],
                            [109.21957684, -0.23797765],
                            [109.21954156, -0.23789449],
                            [109.21950627, -0.23781133],
                            [109.21947098, -0.23772817],
                            [109.2194357, -0.23764501],
                            [109.21940041, -0.23756185],
                            [109.21936513, -0.23747869],
                            [109.21932984, -0.23739553],
                            [109.21929456, -0.23731237],
                            [109.21925927, -0.23722921],
                            [109.21922399, -0.23714605],
                            [109.2191887, -0.23706289],
                            [109.21915341, -0.23697973],
                            [109.21911813, -0.23689657],
                            [109.21908284, -0.23681341],
                            [109.21904756, -0.23673025],
                            [109.21901227, -0.23664709],
                            [109.21897699, -0.23656393],
                            [109.2189417, -0.23648077],
                            [109.21890642, -0.23639761],
                            [109.21887113, -0.23631445],
                            [109.21883584, -0.23623129],
                            [109.21880056, -0.23614813],
                            [109.21876527, -0.23606497],
                            [109.21872999, -0.23598181],
                            [109.2186947, -0.23589865],
                            [109.21865942, -0.23581549],
                            [109.21862413, -0.23573234],
                            [109.21858884, -0.23564918],
                            [109.21855356, -0.23556602],
                            [109.21851583, -0.23548397],
                            [109.21847726, -0.2354023],
                            [109.2184387, -0.23532062],
                            [109.21840014, -0.23523895],
                            [109.21836157, -0.23515728],
                            [109.21832301, -0.23507561],
                            [109.21828445, -0.23499394],
                            [109.21824589, -0.23491227],
                            [109.21820732, -0.2348306],
                            [109.21816876, -0.23474892],
                            [109.2181302, -0.23466725],
                            [109.21809163, -0.23458558],
                            [109.21805307, -0.23450391],
                            [109.21801451, -0.23442224],
                            [109.21798902, -0.23436825],
                            [109.21797594, -0.23434057],
                            [109.21793738, -0.2342589],
                            [109.21789882, -0.23417722],
                            [109.21786025, -0.23409555],
                            [109.21782169, -0.23401388],
                            [109.21778313, -0.23393221],
                            [109.21774456, -0.23385054],
                            [109.217706, -0.23376887],
                            [109.21766744, -0.2336872],
                            [109.21762888, -0.23360553],
                            [109.21759031, -0.23352385],
                            [109.21755175, -0.23344218],
                            [109.21751319, -0.23336051],
                            [109.21747462, -0.23327884],
                            [109.21743606, -0.23319717],
                            [109.2173975, -0.2331155],
                            [109.21735893, -0.23303383],
                            [109.21732037, -0.23295215],
                            [109.21728181, -0.23287048],
                            [109.21724324, -0.23278881],
                            [109.21720468, -0.23270714],
                            [109.21716612, -0.23262547],
                            [109.21712755, -0.2325438],
                            [109.21708899, -0.23246213],
                            [109.21705043, -0.23238046],
                            [109.21701186, -0.23229878],
                            [109.2169733, -0.23221711],
                            [109.21693474, -0.23213544],
                            [109.21689617, -0.23205377],
                            [109.21685761, -0.2319721],
                            [109.21680803, -0.23189676],
                            [109.21675778, -0.2318218],
                            [109.21670754, -0.23174684],
                            [109.2166573, -0.23167188],
                            [109.21660706, -0.23159692],
                            [109.21655681, -0.23152196],
                            [109.21650657, -0.231447],
                            [109.21645633, -0.23137204],
                            [109.21640608, -0.23129708],
                            [109.21635584, -0.23122212],
                            [109.2163056, -0.23114716],
                            [109.21625536, -0.2310722],
                            [109.21620511, -0.23099724],
                            [109.21615487, -0.23092228],
                            [109.21610463, -0.23084732],
                            [109.21605438, -0.23077237],
                            [109.21600414, -0.23069741],
                            [109.2159539, -0.23062245],
                            [109.21590366, -0.23054749],
                            [109.21585341, -0.23047253],
                            [109.21580317, -0.23039757],
                            [109.21575293, -0.23032261],
                            [109.21570268, -0.23024765],
                            [109.21565244, -0.23017269],
                            [109.2156022, -0.23009773],
                            [109.21555195, -0.23002277],
                            [109.21550171, -0.22994781],
                            [109.21545147, -0.22987285],
                            [109.21540123, -0.22979789],
                            [109.21535098, -0.22972293],
                            [109.21530074, -0.22964797],
                            [109.2152505, -0.22957301],
                            [109.21520025, -0.22949805],
                            [109.21515001, -0.22942309],
                            [109.21509977, -0.22934813],
                            [109.21504953, -0.22927317],
                            [109.21499928, -0.22919821],
                            [109.21494904, -0.22912325],
                            [109.2148988, -0.22904829],
                            [109.21484855, -0.22897333],
                            [109.21479831, -0.22889837],
                            [109.21474807, -0.22882342],
                            [109.21469782, -0.22874846],
                            [109.21464758, -0.2286735],
                            [109.21459734, -0.22859854],
                            [109.2145471, -0.22852358],
                            [109.21449685, -0.22844862],
                            [109.21444661, -0.22837366],
                            [109.21439637, -0.2282987],
                            [109.21434612, -0.22822374],
                            [109.21429588, -0.22814878],
                            [109.21424564, -0.22807382],
                            [109.2141954, -0.22799886],
                            [109.21414515, -0.2279239],
                            [109.21409491, -0.22784894],
                            [109.21404467, -0.22777398],
                            [109.21399442, -0.22769902],
                            [109.21393556, -0.22763088],
                            [109.21387516, -0.22756394],
                            [109.21381476, -0.22749701],
                            [109.21375436, -0.22743008],
                            [109.21369396, -0.22736314],
                            [109.21363356, -0.22729621],
                            [109.21357316, -0.22722928],
                            [109.21351277, -0.22716234],
                            [109.21345237, -0.22709541],
                            [109.21339197, -0.22702848],
                            [109.21333157, -0.22696154],
                            [109.21327117, -0.22689461],
                            [109.21321077, -0.22682767],
                            [109.21315037, -0.22676074],
                            [109.21308998, -0.22669381],
                            [109.21302958, -0.22662687],
                            [109.21296918, -0.22655994],
                            [109.21290878, -0.22649301],
                            [109.21284838, -0.22642607],
                            [109.21278798, -0.22635914],
                            [109.21272759, -0.22629221],
                            [109.21266719, -0.22622527],
                            [109.21260679, -0.22615834],
                            [109.21254639, -0.2260914],
                            [109.21248599, -0.22602447],
                            [109.21242559, -0.22595754],
                            [109.21236519, -0.2258906],
                            [109.2123048, -0.22582367],
                            [109.2122444, -0.22575674],
                            [109.212184, -0.2256898],
                            [109.2121236, -0.22562287],
                            [109.2120632, -0.22555593],
                            [109.2120028, -0.225489],
                            [109.2119424, -0.22542207],
                            [109.21188201, -0.22535513],
                            [109.21182161, -0.2252882],
                            [109.21176121, -0.22522127],
                            [109.21170081, -0.22515433],
                            [109.21164041, -0.2250874],
                            [109.21158001, -0.22502047],
                            [109.21151962, -0.22495353],
                            [109.21145922, -0.2248866],
                            [109.21139882, -0.22481967],
                            [109.21133842, -0.22475273],
                            [109.21127802, -0.2246858],
                            [109.21121616, -0.22462048],
                            [109.21114441, -0.22456607],
                            [109.21107267, -0.22451165],
                            [109.21100093, -0.22445724],
                            [109.21092919, -0.22440283],
                            [109.21085745, -0.22434841],
                            [109.2107857, -0.224294],
                            [109.21071396, -0.22423958],
                            [109.21064222, -0.22418517],
                            [109.21057048, -0.22413075],
                            [109.21049874, -0.22407634],
                            [109.21042699, -0.22402193],
                            [109.21035525, -0.22396751],
                            [109.21028351, -0.2239131],
                            [109.21021177, -0.22385868],
                            [109.21014003, -0.22380427],
                            [109.21006829, -0.22374986],
                            [109.20999654, -0.22369544],
                            [109.2099248, -0.22364103],
                            [109.20985306, -0.22358661],
                            [109.20978132, -0.2235322],
                            [109.20970958, -0.22347778],
                            [109.20963783, -0.22342337],
                            [109.20956609, -0.22336896],
                            [109.20949435, -0.22331454],
                            [109.20942261, -0.22326013],
                            [109.20935087, -0.22320571],
                            [109.20927912, -0.2231513],
                            [109.20920738, -0.22309688],
                            [109.20913564, -0.22304247],
                            [109.20906331, -0.22298887],
                            [109.20898953, -0.2229373],
                            [109.20891574, -0.22288573],
                            [109.20884196, -0.22283416],
                            [109.20876817, -0.22278259],
                            [109.20869438, -0.22273102],
                            [109.2086206, -0.22267945],
                            [109.20854681, -0.22262788],
                            [109.20847303, -0.22257631],
                            [109.20839924, -0.22252474],
                            [109.20832546, -0.22247317],
                            [109.20825167, -0.2224216],
                            [109.20817788, -0.22237003],
                            [109.2081041, -0.22231846],
                            [109.20803031, -0.22226689],
                            [109.20795653, -0.22221532],
                            [109.20788274, -0.22216375],
                            [109.20780896, -0.22211218],
                            [109.20773517, -0.22206061],
                            [109.20766139, -0.22200904],
                            [109.2075876, -0.22195747],
                            [109.20751381, -0.2219059],
                            [109.20744003, -0.22185433],
                            [109.20736624, -0.22180276],
                            [109.20729246, -0.22175119],
                            [109.20721867, -0.22169962],
                            [109.20714489, -0.22164805],
                            [109.2070711, -0.22159648],
                            [109.20699731, -0.22154491],
                            [109.20692353, -0.22149334],
                            [109.20684967, -0.22144191],
                            [109.2067671, -0.2214063],
                            [109.20668454, -0.22137068],
                            [109.20660197, -0.22133507],
                            [109.20651941, -0.22129945],
                            [109.20643685, -0.22126384],
                            [109.20635428, -0.22122822],
                            [109.20627172, -0.22119261],
                            [109.20618915, -0.22115699],
                            [109.20610659, -0.22112138],
                            [109.20602403, -0.22108576],
                            [109.20594146, -0.22105015],
                            [109.2058589, -0.22101453],
                            [109.20577633, -0.22097892],
                            [109.20569377, -0.2209433],
                            [109.20561121, -0.22090769],
                            [109.20552864, -0.22087207],
                            [109.20544608, -0.22083646],
                            [109.20536352, -0.22080084],
                            [109.20528095, -0.22076523],
                            [109.20519839, -0.22072961],
                            [109.20511582, -0.220694],
                            [109.20503326, -0.22065838],
                            [109.2049507, -0.22062277],
                            [109.20486813, -0.22058715],
                            [109.20478557, -0.22055154],
                            [109.20470301, -0.22051592],
                            [109.20462044, -0.22048031],
                            [109.20453788, -0.22044469],
                            [109.20445531, -0.22040908],
                            [109.20437275, -0.22037346],
                            [109.20429019, -0.22033785],
                            [109.20420762, -0.22030223],
                            [109.20412506, -0.22026662],
                            [109.20404249, -0.220231],
                            [109.20395993, -0.22019539],
                            [109.20387737, -0.22015977],
                            [109.20379493, -0.22012386],
                            [109.20371309, -0.2200866],
                            [109.20363125, -0.22004933],
                            [109.20354941, -0.22001207],
                            [109.20346756, -0.21997481],
                            [109.20338572, -0.21993754],
                            [109.20330388, -0.21990028],
                            [109.20322204, -0.21986301],
                            [109.20314019, -0.21982575],
                            [109.20305835, -0.21978848],
                            [109.20297651, -0.21975122],
                            [109.20289467, -0.21971395],
                            [109.20281283, -0.21967669],
                            [109.20273098, -0.21963943],
                            [109.20264914, -0.21960216],
                            [109.2025673, -0.2195649],
                            [109.20248546, -0.21952763],
                            [109.20240361, -0.21949037],
                            [109.20232177, -0.2194531],
                            [109.20223993, -0.21941584],
                            [109.20215809, -0.21937857],
                            [109.20207625, -0.21934131],
                            [109.2019944, -0.21930405],
                            [109.20191256, -0.21926678],
                            [109.20183072, -0.21922952],
                            [109.20174888, -0.21919225],
                            [109.20166704, -0.21915499],
                            [109.20158519, -0.21911772],
                            [109.20150335, -0.21908046],
                            [109.20142151, -0.21904319],
                            [109.20133967, -0.21900593],
                            [109.20125783, -0.21896867],
                            [109.20117431, -0.21893614],
                            [109.20108742, -0.21891324],
                            [109.20100053, -0.21889034],
                            [109.20091363, -0.21886743],
                            [109.20082674, -0.21884453],
                            [109.20073984, -0.21882162],
                            [109.20065295, -0.21879872],
                            [109.20056605, -0.21877582],
                            [109.20047916, -0.21875291],
                            [109.20039226, -0.21873001],
                            [109.20030537, -0.21870711],
                            [109.20021847, -0.2186842],
                            [109.20013158, -0.2186613],
                            [109.20004468, -0.2186384],
                            [109.19995779, -0.21861549],
                            [109.1998709, -0.21859259],
                            [109.199784, -0.21856968],
                            [109.19969711, -0.21854678],
                            [109.19961021, -0.21852388],
                            [109.19952332, -0.21850097],
                            [109.19943642, -0.21847807],
                            [109.19934953, -0.21845517],
                            [109.19926263, -0.21843226],
                            [109.19917574, -0.21840936],
                            [109.19908884, -0.21838646],
                            [109.19900195, -0.21836355],
                            [109.19891505, -0.21834065],
                            [109.19882816, -0.21831774],
                            [109.19874127, -0.21829484],
                            [109.19865437, -0.21827194],
                            [109.19856748, -0.21824903],
                            [109.19848058, -0.21822613],
                            [109.19839369, -0.21820323],
                            [109.19830679, -0.21818032],
                            [109.1982199, -0.21815742],
                            [109.198133, -0.21813452],
                            [109.19804611, -0.21811161],
                            [109.19795921, -0.21808871],
                            [109.19787232, -0.2180658],
                            [109.19778543, -0.2180429],
                            [109.19769853, -0.21802],
                            [109.19761164, -0.21799709],
                            [109.19752474, -0.21797419],
                            [109.19743785, -0.21795129],
                            [109.19735095, -0.21792838],
                            [109.19726406, -0.21790548],
                            [109.19717716, -0.21788258],
                            [109.19709027, -0.21785967],
                            [109.19713045, -0.2177302],
                            [109.19716894, -0.21760022],
                            [109.19720566, -0.21746972],
                            [109.19724055, -0.21733871],
                            [109.19727329, -0.21720713],
                            [109.19730366, -0.21707498],
                            [109.19733189, -0.21694236],
                            [109.19735793, -0.21680928],
                            [109.19738171, -0.21667577],
                            [109.19740313, -0.21654186],
                            [109.19742142, -0.21640747],
                            [109.19743729, -0.21627278],
                            [109.19745075, -0.21613783],
                            [109.19746184, -0.21600265],
                            [109.19746999, -0.21586726],
                            [109.19747532, -0.21573173],
                            [109.19747841, -0.21559613],
                            [109.19747938, -0.2154605],
                            [109.19747723, -0.21532487],
                            [109.19747306, -0.2151893],
                            [109.19746764, -0.21505377],
                            [109.1974601, -0.21491834],
                            [109.19745217, -0.21478294],
                            [109.19744316, -0.2146476],
                            [109.19743407, -0.21451227],
                            [109.19742427, -0.21437698],
                            [109.19741447, -0.2142417],
                            [109.19740451, -0.21410643],
                            [109.19739439, -0.21397117],
                            [109.19738426, -0.21383591],
                            [109.19737413, -0.21370065],
                            [109.19736396, -0.2135654],
                            [109.1973538, -0.21343014],
                            [109.19734364, -0.21329489],
                            [109.19733353, -0.21315963],
                            [109.1973235, -0.21302436],
                            [109.19731346, -0.2128891],
                            [109.19730343, -0.21275383],
                            [109.1972934, -0.21261857],
                            [109.19720361, -0.21253262],
                            [109.1970883, -0.21246246],
                            [109.19697299, -0.2123923],
                            [109.19685768, -0.21232215],
                            [109.19674236, -0.21225199],
                            [109.19662705, -0.21218183],
                            [109.19651174, -0.21211167],
                            [109.19639643, -0.21204151],
                            [109.19628107, -0.21197143],
                            [109.19616568, -0.2119014],
                            [109.19605029, -0.21183137],
                            [109.19593491, -0.21176133],
                            [109.19582023, -0.21169013],
                            [109.19570585, -0.21161844],
                            [109.19559147, -0.21154676],
                            [109.19547709, -0.21147507],
                            [109.19536271, -0.21140339],
                            [109.1952485, -0.21133143],
                            [109.19513487, -0.21125854],
                            [109.19502124, -0.21118565],
                            [109.19490761, -0.21111276],
                            [109.19479398, -0.21103987],
                            [109.1946804, -0.2109669],
                            [109.19456762, -0.21089269],
                            [109.19445484, -0.21081848],
                            [109.19434206, -0.21074427],
                            [109.19422928, -0.21067006],
                            [109.19411664, -0.21059563],
                            [109.1940048, -0.21051999],
                            [109.19389296, -0.21044435],
                            [109.19378111, -0.21036872],
                            [109.19366927, -0.21029308],
                            [109.19355792, -0.21021672],
                            [109.1934471, -0.21013958],
                            [109.19333627, -0.21006243],
                            [109.19322545, -0.20998529],
                            [109.19311463, -0.20990815],
                            [109.19300488, -0.20982946],
                            [109.19289514, -0.20975077],
                            [109.19278539, -0.20967208],
                            [109.19267565, -0.20959338],
                            [109.19256664, -0.20951368],
                            [109.19245801, -0.20943343],
                            [109.19234938, -0.20935319],
                            [109.19224076, -0.20927294],
                            [109.19213259, -0.20919207],
                            [109.19202508, -0.20911032],
                            [109.19191756, -0.20902857],
                            [109.19181004, -0.20894682],
                            [109.19170283, -0.20886467],
                            [109.19159641, -0.20878149],
                            [109.19148998, -0.20869831],
                            [109.19138355, -0.20861513],
                            [109.19127737, -0.20853164],
                            [109.191172, -0.20844711],
                            [109.19106663, -0.20836258],
                            [109.19096126, -0.20827805],
                            [109.19085614, -0.20819319],
                            [109.19075178, -0.2081074],
                            [109.19064742, -0.20802161],
                            [109.19054306, -0.20793582],
                            [109.19043903, -0.20784962],
                            [109.19033562, -0.20776267],
                            [109.1902322, -0.20767573],
                            [109.19012879, -0.20758878],
                            [109.19002582, -0.2075013],
                            [109.18992328, -0.20741331],
                            [109.18982075, -0.20732531],
                            [109.18971821, -0.20723732],
                            [109.18961624, -0.20714867],
                            [109.18951449, -0.20705975],
                            [109.18941274, -0.20697083],
                            [109.189311, -0.20688192],
                            [109.18920993, -0.20679222],
                            [109.18910889, -0.20670249],
                            [109.18900785, -0.20661276],
                            [109.18890697, -0.20652284],
                            [109.1888066, -0.20643235],
                            [109.18870623, -0.20634187],
                            [109.18860586, -0.20625138],
                            [109.18850587, -0.20616046],
                            [109.18840616, -0.20606924],
                            [109.18830644, -0.20597803],
                            [109.18820673, -0.2058868],
                            [109.18810766, -0.20579487],
                            [109.18800859, -0.20570294],
                            [109.18790952, -0.20561101],
                            [109.18781079, -0.2055187],
                            [109.18771238, -0.20542606],
                            [109.18761396, -0.20533343],
                            [109.18751566, -0.20524067],
                            [109.18741791, -0.20514731],
                            [109.18732017, -0.20505395],
                            [109.18722243, -0.20496059],
                            [109.18712535, -0.20486654],
                            [109.18702831, -0.20477243],
                            [109.18693128, -0.20467833],
                            [109.18683491, -0.20458353],
                            [109.18673864, -0.20448864],
                            [109.18664236, -0.20439375],
                            [109.18654694, -0.20429798],
                            [109.18645153, -0.20420222],
                            [109.18635642, -0.20410614],
                            [109.18626201, -0.20400937],
                            [109.18616761, -0.20391259],
                            [109.18607415, -0.20381489],
                            [109.18598093, -0.20371695],
                            [109.18588835, -0.20361841],
                            [109.18579651, -0.20351916],
                            [109.18570508, -0.20341954],
                            [109.18561481, -0.20331884],
                            [109.18552488, -0.20321784],
                            [109.18543637, -0.20311557],
                            [109.18534829, -0.20301294],
                            [109.18526171, -0.20290901],
                            [109.18517583, -0.2028045],
                            [109.18509131, -0.20269886],
                            [109.18500791, -0.20259234],
                            [109.18492553, -0.202485],
                            [109.18484481, -0.20237641],
                            [109.18476465, -0.20226739],
                            [109.18468667, -0.20215678],
                            [109.18460927, -0.20204576],
                            [109.1845334, -0.20193366],
                            [109.18445859, -0.20182086],
                            [109.18438469, -0.20170744],
                            [109.18431216, -0.20159314],
                            [109.18424003, -0.20147857],
                            [109.18416937, -0.20136308],
                            [109.18409887, -0.20124749],
                            [109.18402953, -0.20113119],
                            [109.18396033, -0.20101481],
                            [109.18389201, -0.2008979],
                            [109.18382378, -0.20078093],
                            [109.18375643, -0.20066345],
                            [109.18368908, -0.20054598],
                            [109.18362267, -0.20042796],
                            [109.18355629, -0.20030992],
                            [109.18349069, -0.20019144],
                            [109.18342531, -0.20007285],
                            [109.18336051, -0.19995392],
                            [109.18329617, -0.19983475],
                            [109.18323218, -0.19971538],
                            [109.18316896, -0.1995956],
                            [109.18310582, -0.19947578],
                            [109.18304382, -0.19935535],
                            [109.18298183, -0.19923492],
                            [109.18292094, -0.19911392],
                            [109.1828603, -0.19899279],
                            [109.18280056, -0.19887121],
                            [109.18274143, -0.19874934],
                            [109.18268296, -0.19862714],
                            [109.18262538, -0.1985045],
                            [109.18256829, -0.19838164],
                            [109.18251231, -0.19825827],
                            [109.1824567, -0.19813472],
                            [109.18240235, -0.19801061],
                            [109.18234835, -0.19788634],
                            [109.18229567, -0.1977615],
                            [109.18224342, -0.19763647],
                            [109.18219247, -0.1975109],
                            [109.18214212, -0.19738509],
                            [109.18209297, -0.1972588],
                            [109.18204472, -0.19713216],
                            [109.18199745, -0.19700514],
                            [109.18195151, -0.19687763],
                            [109.18190621, -0.19674988],
                            [109.18186291, -0.19662144],
                            [109.18182031, -0.19649276],
                            [109.1817794, -0.19636353],
                            [109.18174001, -0.19623382],
                            [109.18170163, -0.1961038],
                            [109.1816657, -0.19597307],
                            [109.18163113, -0.19584198],
                            [109.18159791, -0.19571052],
                            [109.1815675, -0.19557838],
                            [109.18153865, -0.1954459],
                            [109.18151144, -0.19531305],
                            [109.18148698, -0.19517967],
                            [109.18146463, -0.19504591],
                            [109.18144414, -0.19491186],
                            [109.18142595, -0.19477746],
                            [109.18141045, -0.19464272],
                            [109.18139668, -0.1945078],
                            [109.18138455, -0.19437271],
                            [109.18137515, -0.1942374],
                            [109.18136701, -0.19410201],
                            [109.18136011, -0.19396655],
                            [109.1813553, -0.193831],
                            [109.18135122, -0.19369542],
                            [109.1813484, -0.19355981],
                            [109.18134669, -0.19342418],
                            [109.18134559, -0.19328855],
                            [109.18134586, -0.19315291],
                            [109.18134638, -0.19301727],
                            [109.18134834, -0.19288164],
                            [109.18135043, -0.19274602],
                            [109.18135377, -0.19261042],
                            [109.18135723, -0.19247482],
                            [109.18136187, -0.19233926],
                            [109.18136653, -0.1922037],
                            [109.1813724, -0.19206819],
                            [109.18137828, -0.19193268],
                            [109.18138516, -0.19179721],
                            [109.1813922, -0.19166176],
                            [109.18139995, -0.19152634],
                            [109.1814081, -0.19139095],
                            [109.1814166, -0.19125558],
                            [109.18142575, -0.19112025],
                            [109.18143493, -0.19098493],
                            [109.18144502, -0.19084967],
                            [109.1814551, -0.19071441],
                            [109.18146582, -0.19057919],
                            [109.1814768, -0.19044401],
                            [109.18148814, -0.19030885],
                            [109.18150003, -0.19017374],
                            [109.18151205, -0.19003863],
                            [109.18152488, -0.18990361],
                            [109.18153772, -0.18976859],
                            [109.18155153, -0.18963366],
                            [109.1815654, -0.18949874],
                            [109.1815803, -0.18936393],
                            [109.18159535, -0.18922914],
                            [109.18161173, -0.18909451],
                            [109.18162847, -0.18895992],
                            [109.18164653, -0.1888255],
                            [109.18166565, -0.18869124],
                            [109.18168576, -0.18855712],
                            [109.18170771, -0.18842329],
                            [109.18173141, -0.18828977],
                            [109.18175698, -0.1881566],
                            [109.18178478, -0.18802388],
                            [109.18181513, -0.18789173],
                            [109.18184829, -0.18776027],
                            [109.18188451, -0.18762963],
                            [109.18192418, -0.18750001],
                            [109.18196787, -0.18737171],
                            [109.18201677, -0.18724533],
                            [109.18207062, -0.18712102],
                            [109.18213108, -0.18699982],
                            [109.18219738, -0.18688177],
                            [109.18226879, -0.18676675],
                            [109.18234344, -0.18665384],
                            [109.18241783, -0.18654075],
                            [109.18248418, -0.18642279],
                            [109.18253604, -0.18629765],
                            [109.18257837, -0.1861689],
                            [109.18261595, -0.18603865],
                            [109.18265072, -0.18590761],
                            [109.18268378, -0.18577612],
                            [109.18271575, -0.18564436],
                            [109.18274664, -0.18551233],
                            [109.18277696, -0.18538017],
                            [109.18280692, -0.18524792],
                            [109.18283621, -0.18511552],
                            [109.18286542, -0.18498311],
                            [109.18289407, -0.18485057],
                            [109.18292273, -0.18471803],
                            [109.18295094, -0.1845854],
                            [109.18297913, -0.18445276],
                            [109.18300706, -0.18432006],
                            [109.18303487, -0.18418735],
                            [109.18306262, -0.18405461],
                            [109.18309012, -0.18392183],
                            [109.18311763, -0.18378904],
                            [109.18314497, -0.18365622],
                            [109.18317219, -0.18352338],
                            [109.18319941, -0.18339054],
                            [109.18322641, -0.18325765],
                            [109.18325335, -0.18312475],
                            [109.18328029, -0.18299184],
                            [109.18330698, -0.18285889],
                            [109.18333362, -0.18272593],
                            [109.18336027, -0.18259296],
                            [109.18338663, -0.18245995],
                            [109.18341295, -0.18232692],
                            [109.18343928, -0.18219389],
                            [109.18346526, -0.1820608],
                            [109.18349123, -0.1819277],
                            [109.18351716, -0.18179459],
                            [109.1835427, -0.18166141],
                            [109.18356824, -0.18152823],
                            [109.18359363, -0.18139502],
                            [109.18361864, -0.18126174],
                            [109.18364365, -0.18112845],
                            [109.1836682, -0.18099508],
                            [109.18369249, -0.18086166],
                            [109.18371679, -0.18072825],
                            [109.18374051, -0.18059473],
                            [109.18374789, -0.18055268],
                            [109.19066256, -0.1804826],
                            [109.19849932, -0.18055827],
                            [109.20029819, -0.18047261],
                            [109.20140226, -0.18029177],
                            [109.20361582, -0.17924686],
                            [109.20480707, -0.1784645],
                            [109.20474521, -0.17706142],
                            [109.20478969, -0.17592947],
                            [109.2055787, -0.1734967],
                            [109.20643338, -0.17086144],
                            [109.20764682, -0.16763223],
                            [109.20785637, -0.16564151],
                            [109.20902824, -0.16314616],
                            [109.21205219, -0.15902518],
                            [109.21550523, -0.15515838],
                            [109.21879664, -0.14853432],
                            [109.21956259, -0.14659175],
                            [109.21965924, -0.14572189],
                            [109.21964909, -0.14489023],
                            [109.21932055, -0.14378703],
                            [109.21803826, -0.14104178],
                            [109.21798544, -0.1409077],
                            [109.21794818, -0.14081313],
                            [109.21796712, -0.14064206],
                            [109.21804687, -0.13992144],
                            [109.21807105, -0.13857287],
                            [109.2179295, -0.13760793],
                            [109.21794666, -0.13601254],
                            [109.21701827, -0.1317306],
                            [109.21686468, -0.12974565],
                            [109.21699597, -0.1285617],
                            [109.2176704, -0.12670452],
                            [109.21767825, -0.12632221],
                            [109.21749921, -0.12533219],
                            [109.21651612, -0.12410542],
                            [109.21629136, -0.12307152],
                            [109.21637359, -0.12275462],
                            [109.21677658, -0.12038871],
                            [109.21763683, -0.11831597],
                            [109.21898873, -0.11873843],
                            [109.22077443, -0.11970942],
                            [109.22181508, -0.12031857],
                            [109.22251671, -0.12063888],
                            [109.22283368, -0.12078359],
                            [109.22317097, -0.12098226],
                            [109.22381732, -0.12131307],
                            [109.22427988, -0.1215434],
                            [109.22446072, -0.12166714],
                            [109.22460739, -0.12177887],
                            [109.22491587, -0.12214459],
                            [109.22499112, -0.1222489],
                            [109.22506013, -0.12232147],
                            [109.22516695, -0.12236955],
                            [109.22532304, -0.12243427],
                            [109.22553243, -0.122499],
                            [109.22576276, -0.1225561],
                            [109.22600642, -0.12263224],
                            [109.22660034, -0.12281308],
                            [109.22720948, -0.12299963],
                            [109.22823988, -0.1233348],
                            [109.22868817, -0.12345235],
                            [109.22907774, -0.12348444],
                            [109.22988218, -0.12337456],
                            [109.23007521, -0.12335401],
                            [109.2302846, -0.12335401],
                            [109.23044429, -0.12337817],
                            [109.23091126, -0.12357448],
                            [109.23124736, -0.12380945],
                            [109.23163699, -0.12411283],
                            [109.23184222, -0.12420206],
                            [109.23203258, -0.12422883],
                            [109.23216047, -0.12419611],
                            [109.23228299, -0.12410126],
                            [109.23257391, -0.12386001],
                            [109.23271667, -0.12373806],
                            [109.23279103, -0.12372022],
                            [109.23292785, -0.12372022],
                            [109.23312713, -0.12378565],
                            [109.23348702, -0.1238957],
                            [109.23381213, -0.1239262],
                            [109.23426176, -0.12389547],
                            [109.23505194, -0.12366606],
                            [109.23568594, -0.12340137],
                            [109.23585726, -0.12337758],
                            [109.2360381, -0.12339661],
                            [109.2364416, -0.1235968],
                            [109.23684515, -0.12378526],
                            [109.23694985, -0.12378716],
                            [109.23707548, -0.12376812],
                            [109.2371616, -0.1237203],
                            [109.23735848, -0.12337383],
                            [109.23749249, -0.12306751],
                            [109.23754027, -0.12295784],
                            [109.23769732, -0.12289597],
                            [109.23788767, -0.12286266],
                            [109.23831122, -0.12290549],
                            [109.23873612, -0.1229905],
                            [109.23921283, -0.12324259],
                            [109.23973868, -0.12349463],
                            [109.24051676, -0.12399432],
                            [109.24181818, -0.12494905],
                            [109.24225665, -0.1252606],
                            [109.2423151, -0.12530213],
                            [109.24267039, -0.12550885],
                            [109.24587232, -0.12743],
                            [109.24747473, -0.12831195],
                            [109.24770826, -0.12841044],
                            [109.24793478, -0.12846374],
                            [109.24844536, -0.12856875],
                            [109.24859374, -0.12860339],
                            [109.24896702, -0.1286859],
                            [109.2493801, -0.12877157],
                            [109.2497037, -0.12885152],
                            [109.24991372, -0.12892089],
                            [109.25096043, -0.12940697],
                            [109.25354929, -0.13056815],
                            [109.25599537, -0.1316627],
                            [109.2578228, -0.13255738],
                            [109.25977396, -0.1332617],
                            [109.26099224, -0.13362338],
                            [109.26257934, -0.13410036],
                            [109.26258152, -0.13451921],
                            [109.26253944, -0.13530288],
                            [109.26243756, -0.13713898],
                            [109.26227417, -0.14010557],
                            [109.26222227, -0.14243459],
                            [109.26214385, -0.14434666],
                            [109.26218983, -0.14600323],
                            [109.26226409, -0.14700758],
                            [109.26232863, -0.14765076],
                            [109.26235004, -0.14812666],
                            [109.2623548, -0.14871676],
                            [109.26233339, -0.14906654],
                            [109.26226996, -0.14948967],
                            [109.26221723, -0.15028445],
                            [109.26220345, -0.15058599],
                            [109.2621512, -0.15218863],
                            [109.26208605, -0.15315615],
                            [109.26204234, -0.154113],
                            [109.26200789, -0.15640805],
                            [109.26195618, -0.15689649],
                            [109.26190335, -0.15729339],
                            [109.26168955, -0.15842165],
                            [109.26166791, -0.15856924],
                            [109.26128725, -0.16007987],
                            [109.26113853, -0.16083763],
                            [109.26081755, -0.16212994],
                            [109.26044635, -0.16376463],
                            [109.26010371, -0.16557778],
                            [109.25996094, -0.16634159],
                            [109.25995427, -0.1672925],
                            [109.25995427, -0.16828236],
                            [109.26004945, -0.16927221],
                            [109.26041113, -0.17273671],
                            [109.2609822, -0.17719106],
                            [109.26121712, -0.17969343],
                            [109.26153595, -0.18170744],
                            [109.26205457, -0.18303605],
                            [109.26262564, -0.1842924],
                            [109.2628969, -0.18472546],
                            [109.26318243, -0.1851157],
                            [109.26361074, -0.18555828],
                            [109.26415326, -0.18602465],
                            [109.26673098, -0.18797478],
                            [109.27006222, -0.19078254],
                            [109.27696266, -0.19687396],
                            [109.28149761, -0.2020655],
                        ],
                    ],
                ],
            },
        };

        const DesaKalimasLayer = L.geoJson(batasKalimas, {
            style(feature) {
                return feature.properties && feature.properties.style;
            },
            onEachFeature,
        }).addTo(map);

        const SungaiBelidakLayer = L.geoJson(batasSungaiBelidak, {
            style(feature) {
                return feature.properties && feature.properties.style;
            },
            onEachFeature,
        }).addTo(map);

        const PunggurKapuasLayer = L.geoJson(batasPunggurKapuas, {
            style(feature) {
                return feature.properties && feature.properties.style;
            },
            onEachFeature,
        }).addTo(map);

        const PunggurKecilLayer = L.geoJson(batasPunggurKecil, {
            style(feature) {
                return feature.properties && feature.properties.style;
            },
            onEachFeature,
        }).addTo(map);

        const PunggurBesaLayer = L.geoJson(batasPunggurBesar, {
            style(feature) {
                return feature.properties && feature.properties.style;
            },
            onEachFeature,
        }).addTo(map);

        const PalSembilanLayer = L.geoJson(batasPalSembilan, {
            style(feature) {
                return feature.properties && feature.properties.style;
            },
            onEachFeature,
        }).addTo(map);

        // Menampilkan popup data ketika marker di klik
        // @foreach ($pasar as $item)
        //     L.marker([{{ $item->location }}])
        //         .bindPopup(
        //             "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
        //             "<div class='my-2'><strong>Nama Pasar:</strong> <br>{{ $item->dusun }}</div>" +
        //             "<div><a href='{{ route('peta.showSekolah', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Pasar</a></div>" +
        //             "<div class='my-2'></div>"
        //         ).addTo(map);
        // @endforeach

        // @foreach ($sekolah as $item)
        //     L.marker([{{ $item->location }}])
        //         .bindPopup(
        //             "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
        //             "<div class='my-2'><strong>Nama Sekolah:</strong> <br>{{ $item->dusun }}</div>" +
        //             "<div><a href='{{ route('peta.showSekolah', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Sekolah</a></div>" +
        //             "<div class='my-2'></div>"
        //         ).addTo(map);
        // @endforeach

        // @foreach ($rumah_ibadah as $item)
        //     L.marker([{{ $item->location }}])
        //         .bindPopup(
        //             "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
        //             "<div class='my-2'><strong>Nama Rumah Ibadah:</strong> <br>{{ $item->dusun }}</div>" +
        //             "<div><a href='{{ route('peta.showRumahIbadah', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Rumah Ibadah</a></div>" +
        //             "<div class='my-2'></div>"
        //         ).addTo(map);
        // @endforeach

        // @foreach ($wisata_desa as $item)
        //     L.marker([{{ $item->location }}])
        //         .bindPopup(
        //             "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
        //             "<div class='my-2'><strong>Nama Wisata:</strong> <br>{{ $item->dusun }}</div>" +
        //             "<div><a href='{{ route('peta.showWisata', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Wisata</a></div>" +
        //             "<div class='my-2'></div>"
        //         ).addTo(map);
        // @endforeach


        // // Membuat variable data detail potensi
        // var dataPasar = [
        //     @foreach ($pasar as $key => $value)
        //         {
        //             "loc": [{{ $value->location }}],
        //             "title": '{!! $value->name !!}'
        //         },
        //     @endforeach
        // ];

        // var dataSekolah = [
        //     @foreach ($sekolah as $key => $value)
        //         {
        //             "loc": [{{ $value->location }}],
        //             "title": '{!! $value->name !!}'
        //         },
        //     @endforeach
        // ];

        // var dataRumahIbadah = [
        //     @foreach ($rumah_ibadah as $key => $value)
        //         {
        //             "loc": [{{ $value->location }}],
        //             "title": '{!! $value->name !!}'
        //         },
        //     @endforeach
        // ];

        // var dataWisata = [
        //     @foreach ($wisata_desa as $key => $value)
        //         {
        //             "loc": [{{ $value->location }}],
        //             "title": '{!! $value->name !!}'
        //         },
        //     @endforeach
        // ];

        // // pada koding ini kita menambahkan control pencarian data
        // var markersLayer = new L.LayerGroup();
        // map.addLayer(markersLayer);

        // var controlSearch = new L.Control.Search({
        //     position: 'topleft',
        //     layer: markersLayer,
        //     initial: false,
        //     zoom: 17,
        //     markerLocation: true
        // })


        // //menambahkan variabel controlsearch pada addControl
        // map.addControl(controlSearch);

        // // looping variabel dataPasar utuk menampilkan data space ketika melakukan pencarian data
        // for (i in dataPasar) {

        //     var title = dataPasar[i].title,
        //         loc = dataPasar[i].loc,
        //         marker = new L.Marker(new L.latLng(loc), {
        //             title: title
        //         });
        //     markersLayer.addLayer(marker);

        //     // melakukan looping data untuk memunculkan popup dari space yang dipilih
        //     @foreach ($pasar as $item)
        //         L.marker([{{ $item->location }}])
        //             .bindPopup(
        //                 "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
        //                 "<div class='my-2'><strong>Nama Spot:</strong> <br>{{ $item->dusun }}</div>" +
        //                 "<a href='{{ route('peta.showPasar', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Pasar</a></div>" +
        //                 "<div class='my-2'></div>"
        //             ).addTo(map);
        //     @endforeach
        // }

        // for (i in dataSekolah) {

        //     var title = dataSekolah[i].title,
        //         loc = dataSekolah[i].loc,
        //         marker = new L.Marker(new L.latLng(loc), {
        //             title: title
        //         });
        //     markersLayer.addLayer(marker);

        //     // melakukan looping data untuk memunculkan popup dari space yang dipilih
        //     @foreach ($sekolah as $item)
        //         L.marker([{{ $item->location }}])
        //             .bindPopup(
        //                 "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
        //                 "<div class='my-2'><strong>Nama Spot:</strong> <br>{{ $item->dusun }}</div>" +
        //                 "<a href='{{ route('peta.showSekolah', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Sekolah</a></div>" +
        //                 "<div class='my-2'></div>"
        //             ).addTo(map);
        //     @endforeach
        // }

        // for (i in dataRumahIbadah) {

        //     var title = dataRumahIbadah[i].title,
        //         loc = dataRumahIbadah[i].loc,
        //         marker = new L.Marker(new L.latLng(loc), {
        //             title: title
        //         });
        //     markersLayer.addLayer(marker);

        //     // melakukan looping data untuk memunculkan popup dari space yang dipilih
        //     @foreach ($rumah_ibadah as $item)
        //         L.marker([{{ $item->location }}])
        //             .bindPopup(
        //                 "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
        //                 "<div class='my-2'><strong>Nama Spot:</strong> <br>{{ $item->dusun }}</div>" +
        //                 "<a href='{{ route('peta.showRumahIbadah', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Rumah Ibadah</a></div>" +
        //                 "<div class='my-2'></div>"
        //             ).addTo(map);
        //     @endforeach
        // }

        // for (i in dataWisata) {

        //     var title = dataWisata[i].title,
        //         loc = dataWisata[i].loc,
        //         marker = new L.Marker(new L.latLng(loc), {
        //             title: title
        //         });
        //     markersLayer.addLayer(marker);

        //     // melakukan looping data untuk memunculkan popup dari space yang dipilih
        //     @foreach ($wisata_desa as $item)
        //         L.marker([{{ $item->location }}])
        //             .bindPopup(
        //                 "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
        //                 "<div class='my-2'><strong>Nama Spot:</strong> <br>{{ $item->dusun }}</div>" +
        //                 "<a href='{{ route('peta.showWisata', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Wisata</a></div>" +
        //                 "<div class='my-2'></div>"
        //             ).addTo(map);
        //     @endforeach
        // }

    </script>
@endpush
