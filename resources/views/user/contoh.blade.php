@extends('layouts.user.user-layout')
@extends('layouts.user.map-navbar')

@section('title')
    Contoh
@endsection

@section('add_css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .leaflet-container {
            height: 400px;
            width: 600px;
            max-width: 100%;
            max-height: 100%;
        }
    </style>


    <style>
        #map {
            width: 800px;
            height: 500px;
        }

        .info {
            padding: 6px 8px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .info h4 {
            margin: 0 0 5px;
            color: #777;
        }

        .legend {
            text-align: left;
            line-height: 18px;
            color: #555;
        }

        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
        }
    </style>
@endsection

@section('content')
    <div id="map" class="container-xxl py-5 bg-white">

    </div>
@endsection

@section('leaflet_script')
    <script src="{{ asset('js/us-states.js') }}"></script>
@endsection

@push('scripts')
    <script type="text/javascript">
        const map = L.map('map').setView([37.8, -96], 4);

        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // control that shows state info on hover
        const info = L.control();

        info.onAdd = function(map) {
            this._div = L.DomUtil.create('div', 'info');
            this.update();
            return this._div;
        };

        info.update = function(props) {
            const contents = props ? `<b>${props.name}</b><br />${props.density} people / mi<sup>2</sup>` :
                'Pemetaan Desa Kalimas';
            this._div.innerHTML = `<h4>Informasi Geografis Desa</h4>${contents}`;
        };

        info.addTo(map);


        // get color depending on population density value
        function getColor(d) {
            return d > 1000 ? '#800026' :
                d > 500 ? '#BD0026' :
                d > 200 ? '#E31A1C' :
                d > 100 ? '#FC4E2A' :
                d > 50 ? '#FD8D3C' :
                d > 20 ? '#FEB24C' :
                d > 10 ? '#FED976' : '#FFEDA0';
        }

        function style(feature) {
            return {
                weight: 2,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.7,
                fillColor: getColor(feature.properties.density)
            };
        }

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

        /* global statesData */
        const geojson = L.geoJson(statesData, {
            style,
            onEachFeature
        }).addTo(map);

        function resetHighlight(e) {
            geojson.resetStyle(e.target);
            info.update();
        }

        function zoomToFeature(e) {
            map.fitBounds(e.target.getBounds());
        }

        function onEachFeature(feature, layer) {
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
                click: zoomToFeature
            });
        }

        map.attributionControl.addAttribution('Population data &copy; <a href="http://census.gov/">US Census Bureau</a>');


        const legend = L.control({
            position: 'bottomright'
        });

        legend.onAdd = function(map) {

            const div = L.DomUtil.create('div', 'info legend');
            const grades = [0, 10, 20, 50, 100, 200, 500, 1000];
            const labels = [];
            let from, to;

            for (let i = 0; i < grades.length; i++) {
                from = grades[i];
                to = grades[i + 1];

                labels.push(`<i style="background:${getColor(from + 1)}"></i> ${from}${to ? `&ndash;${to}` : '+'}`);
            }

            div.innerHTML = labels.join('<br>');
            return div;
        };

        legend.addTo(map);
    </script>

    {{-- Kalimas --}}
    {{-- <script type="text/javascript">
        var geoJsonKalimas = {
            type: "FeatureCollection",
            features: [{
                type: "Feature",
                properties: {
                    "FID": "ADMINISTRASIDESA_AR_25K.22",
                    "fid": 22,
                    "the_geom": "MULTIPOLYGON (((109.29685419800006 -0.0875154159999738, 109.29610072600008 -0.0901917309999476, 109.29618591400003 -0.0907198969999286, 109.29630999900007 -0.0914892229999396, 109.27879509400009 -0.0952424169999517, 109.27755913900006 -0.0955072649999806, 109.27734416700008 -0.0955628609999621, 109.27513157300007 -0.0961350829999787, 109.26928485300004 -0.1002924249999637, 109.26818313400008 -0.1011182359999339, 109.26705996900006 -0.1019050239999615, 109.26444730600008 -0.1037938319999512, 109.26220147100008 -0.1054316419999282, 109.25799915900006 -0.1084306629999787, 109.25612958500005 -0.1098006099999793, 109.25403685600008 -0.1111399569999776, 109.25336823800006 -0.1112827679999668, 109.25052354500008 -0.1119695469999442, 109.24967557300005 -0.1120660989999465, 109.24191732700007 -0.1129494639999393, 109.24155540000004 -0.1129494639999393, 109.24091640700004 -0.1129969659999688, 109.23621005700005 -0.1134971269999596, 109.23557511200005 -0.1135379709999711, 109.23556579000007 -0.1135411039999781, 109.23543518200006 -0.1135849889999463, 109.23527881600006 -0.1136422499999412, 109.23485444300007 -0.1137888519999706, 109.23479791600005 -0.1138066169999661, 109.23473669300006 -0.1138292929999807, 109.23461563500007 -0.1139279319999673, 109.23455509700005 -0.1139985599999704, 109.23452209900006 -0.1140422429999717, 109.23446230600007 -0.114058924999938, 109.23441891200008 -0.1140710309999804, 109.23434850100006 -0.1140906749999431, 109.23403535900007 -0.1141087909999783, 109.23403520400007 -0.1141089409999267, 109.23400434400008 -0.1141388359999382, 109.23395554400008 -0.1141900769999324, 109.23394124800006 -0.1142560569999773, 109.23390539000007 -0.1144215529999428, 109.23387407400008 -0.1144461589999537, 109.23384385100007 -0.1144581639999274, 109.23374705200007 -0.1144424059999665, 109.23373256900004 -0.114440047999949, 109.23365560700006 -0.1143874569999639, 109.23356991300005 -0.1143329239999389, 109.23356785100009 -0.1143326399999296, 109.23349938100006 -0.1143261189999407, 109.23331487600007 -0.1144891669999311, 109.23320874600006 -0.1145829549999462, 109.23309852200003 -0.114608263999969, 109.23306613000005 -0.1146192719999704, 109.23306318300007 -0.1146202739999467, 109.23297674300005 -0.1146496479999541, 109.23287554100006 -0.1146939239999369, 109.23278697800004 -0.1147420009999678, 109.23277501500007 -0.1147494779999647, 109.23277313000006 -0.114749518999929, 109.23277264200004 -0.1147497829999793, 109.23204463200005 -0.1147754779999559, 109.23203636900007 -0.114775768999948, 109.23200862700008 -0.1147983099999692, 109.23190312100007 -0.1148652159999415, 109.23170556700006 -0.1150031309999804, 109.23169865100004 -0.1150079599999572, 109.23169791800007 -0.1150081349999255, 109.23169174700007 -0.1150121709999326, 109.23152530900006 -0.1150572849999776, 109.23149499200008 -0.1151092579999613, 109.23136453500007 -0.1151950839999358, 109.23132057300006 -0.1152317199999402, 109.23116625500006 -0.1152162879999423, 109.23115415600006 -0.1152196759999242, 109.23086175000009 -0.1153061919999345, 109.23065315000008 -0.1154284749999306, 109.23064785900004 -0.1154306429999679, 109.23058378500008 -0.1154569029999379, 109.23043923400007 -0.1155161449999582, 109.23038192100006 -0.1155380279999463, 109.23026240400009 -0.1156177059999663, 109.23016103900005 -0.115685282999948, 109.23011573500008 -0.1157470609999791, 109.23005517000007 -0.1158412739999335, 109.22999106400005 -0.1158784959999366, 109.22998609300004 -0.1158827079999583, 109.22997939800007 -0.1158852699999784, 109.22993557400008 -0.1159107169999629, 109.22989699400006 -0.1159300059999282, 109.22966937600006 -0.1158759949999535, 109.22963687500004 -0.1158788629999776, 109.22962832400009 -0.1158801789999302, 109.22961521000008 -0.1158807749999369, 109.22953304200007 -0.1158845099999439, 109.22950436700006 -0.1158604649999688, 109.22941177300004 -0.1158975029999283, 109.22941177300004 -0.1158991019999576, 109.22939160500005 -0.1159068589999492, 109.22939875400004 -0.1159569019999367, 109.22935665800009 -0.1160229249999247, 109.22927305200005 -0.1161445329999538, 109.22916490500006 -0.1162136669999541, 109.22900169300004 -0.1161249199999475, 109.22893103000007 -0.116157363999946, 109.22885225500005 -0.116431261999935, 109.22882304200004 -0.116450360999977, 109.22873446400007 -0.1165082709999297, 109.22870148700008 -0.1165298309999798, 109.22869684700004 -0.1165279749999399, 109.22863652100006 -0.1165038449999543, 109.22848926700004 -0.1163912389999382, 109.22828137800008 -0.1163739149999401, 109.22811304400005 -0.1164232539999261, 109.22803017900009 -0.1164475419999462, 109.22793308600006 -0.1164743259999454, 109.22764781700005 -0.116558849999933, 109.22752855700008 -0.1165166119999412, 109.22746263600004 -0.1164932649999741, 109.22732375100009 -0.1165318449999404, 109.22724415700009 -0.1165915399999449, 109.22707684300008 -0.1167170259999466, 109.22697674300008 -0.1166669759999763, 109.22697653600005 -0.1166668719999393, 109.22680292900009 -0.116419963999931, 109.22667294100006 -0.1163029749999396, 109.22664789500004 -0.1162812249999661, 109.22649204300006 -0.1163130309999474, 109.22645957300006 -0.1163196579999521, 109.22645805600007 -0.1163219329999379, 109.22645802000005 -0.1163219419999564, 109.22635840700008 -0.1164691969999581, 109.22605716300006 -0.1162593019999463, 109.22596471600008 -0.116239076999932, 109.22577588700005 -0.1161977649999244, 109.22576900200005 -0.116196203999948, 109.22553704100005 -0.1162433209999563, 109.22552209400004 -0.1162463569999659, 109.22530605000009 -0.116196203999948, 109.22517102200004 -0.1160264549999397, 109.22505828400006 -0.1159512959999347, 109.22489972500006 -0.1160073709999665, 109.22470828900003 -0.1160750739999798, 109.22454169400004 -0.1161042279999265, 109.22453504900005 -0.1161053909999623, 109.22450149300005 -0.1160854679999375, 109.22433393800009 -0.116007275999948, 109.22396739000004 -0.1157140369999752, 109.22379435300007 -0.1156419379999534, 109.22377189800005 -0.1156325819999324, 109.22376696800006 -0.1156316689999244, 109.22375979700007 -0.1156289799999399, 109.22375473200009 -0.1156278429999702, 109.22354757700003 -0.1155813379999699, 109.22335376600006 -0.1156338969999524, 109.22328316700003 -0.115648872999941, 109.22310949500007 -0.1158405109999308, 109.22304694700006 -0.1159095289999641, 109.22293903200006 -0.1159526949999758, 109.22291993700009 -0.1159563909999406, 109.22267214100003 -0.1158531429999243, 109.22263152600004 -0.1158362199999488, 109.22233828700007 -0.1155103989999589, 109.22218493200006 -0.1151576819999605, 109.22213372600004 -0.1151178549999372, 109.22211835800005 -0.1151112689999536, 109.22195924400006 -0.1151828699999555, 109.22178052200007 -0.1154254219999302, 109.22175138800009 -0.1154498569999305, 109.22166753500005 -0.1155201849999798, 109.22157260900008 -0.1155592719999277, 109.22147754100007 -0.1154709949999528, 109.22145857200007 -0.1154533809999521, 109.22145237800004 -0.1154321059999575, 109.22139195900007 -0.1152245799999605, 109.22137527100006 -0.1151672599999642, 109.22128089200004 -0.1148430879999296, 109.22127122500007 -0.1148098849999428, 109.22122239800007 -0.1145999289999509, 109.22117418000005 -0.1144552739999654, 109.22107456600008 -0.1143080199999531, 109.22091865000004 -0.1142603779999263, 109.22053343800007 -0.1145964139999478, 109.22048925600006 -0.1146388289999436, 109.22029557700006 -0.114809265999952, 109.22028561800005 -0.1148180309999702, 109.22009827100004 -0.1150542499999574, 109.21998988400009 -0.1150759279999534, 109.21996243800004 -0.1150718619999793, 109.21991627300008 -0.1150487789999488, 109.21990519200006 -0.1150183059999677, 109.21979258500005 -0.1149100309999653, 109.21977526100005 -0.1148493969999436, 109.21972649500009 -0.1146285129999569, 109.21970455900004 -0.114529154999957, 109.21960954000008 -0.1143537359999414, 109.21944567700007 -0.1143127699999695, 109.21934791400008 -0.1143213969999692, 109.21928134400008 -0.1143380389999606, 109.21911694700009 -0.1144336189999535, 109.21873414500004 -0.1146803139999406, 109.21872715500007 -0.1146848179999438, 109.21872648700008 -0.1146857419999492, 109.21865731700007 -0.1147813949999659, 109.21855391500009 -0.114775768999948, 109.21847595600008 -0.1147454519999656, 109.21840666000008 -0.1146674939999457, 109.21840161900008 -0.1146612399999754, 109.21818588700006 -0.1143935719999263, 109.21817278500004 -0.1143773159999455, 109.21800387500008 -0.1142213989999732, 109.21790000100009 -0.114128710999978, 109.21772235900005 -0.1139701999999261, 109.21772189300009 -0.1139695269999379, 109.21748848500005 -0.1136323809999453, 109.21736449100007 -0.1134610449999514, 109.21722671200007 -0.1132813219999775, 109.21704768300003 -0.1129944779999619, 109.21699729000005 -0.1129611499999328, 109.21695632600006 -0.1129476549999708, 109.21675497500007 -0.1129764189999491, 109.21649434000005 -0.1129075719999264, 109.21649119900007 -0.1129048549999538, 109.21643375700006 -0.1129100779999703, 109.21639136000005 -0.1128592759999378, 109.21624820800008 -0.1126980899999239, 109.21603179200008 -0.1125335229999678, 109.21575788900009 -0.1124230599999692, 109.21563933800007 -0.1124092559999781, 109.21502787200006 -0.1124194919999582, 109.21425198700007 -0.112899853999977, 109.21372546600008 -0.1131430749999254, 109.21317581100004 -0.1132572889999324, 109.21266184700005 -0.1132572889999324, 109.21197656300006 -0.1131430749999254, 109.21131269300008 -0.112964614999953, 109.21018482800008 -0.1125148969999259, 109.20897130300006 -0.1119152729999655, 109.20865721500007 -0.1116797059999612, 109.20836454100004 -0.111215710999943, 109.20803617500007 -0.1104519039999445, 109.20745796600005 -0.1091384419999599, 109.20697327000005 -0.1083282349999308, 109.20600030800006 -0.1069916919999514, 109.20549331500007 -0.1063547309999535, 109.20466269400004 -0.1047431169999413, 109.20431053400006 -0.1036104939999518, 109.20397741000005 -0.1021828169999708, 109.20375849900006 -0.1012786219999384, 109.20353958900006 -0.100659961999952, 109.20329212500008 -0.1001459989999489, 109.20296851800003 -0.0997557669999765, 109.20246407200005 -0.0992037319999781, 109.20173119800006 -0.0986041079999609, 109.20057002100003 -0.0977855729999533, 109.19986570100008 -0.0973358549999261, 109.19918755500004 -0.096993212999962, 109.19863004700005 -0.0967230249999602, 109.19824814300006 -0.0966016719999629, 109.19750138900008 -0.0965394099999344, 109.19676375600005 -0.0964977689999387, 109.19604396900007 -0.0964561289999324, 109.19404079400005 -0.0964295819999279, 109.19352664900003 -0.0964323389999322, 109.19323635500007 -0.096408543999928, 109.19307608400004 -0.0963998609999521, 109.19288102200005 -0.0963591709999605, 109.19192715900004 -0.0962131269999418, 109.19124542200007 -0.0961639529999729, 109.19064848600004 -0.0961208949999559, 109.18976987000008 -0.0962080439999795, 109.18917585900004 -0.0962540139999533, 109.18860469200007 -0.0963459849999708, 109.18810206600006 -0.0964034589999301, 109.18772510300005 -0.0963229369999681, 109.18703971700006 -0.0961618969999449, 109.18594310400005 -0.095828332999929, 109.18507495000006 -0.0955982829999584, 109.18475511000008 -0.0953912619999642, 109.18463184500007 -0.0952867489999676, 109.18405741500004 -0.0948971759999608, 109.18407285100005 -0.0948857129999396, 109.18418131900006 -0.0948052509999684, 109.18428984900004 -0.0947248729999615, 109.18439837900007 -0.094644495999944, 109.18450690900005 -0.0945641199999727, 109.18461551100006 -0.0944838399999526, 109.18472411400006 -0.094403563999947, 109.18483271900004 -0.0943232899999771, 109.18494134700006 -0.0942430449999279, 109.18505000100004 -0.0941628379999315, 109.18515865400008 -0.0940826309999352, 109.18526731100008 -0.0940024289999428, 109.18537599300004 -0.0939222599999425, 109.18548467500005 -0.0938420909999422, 109.18559335700007 -0.0937619209999525, 109.18570204300005 -0.093681758999935, 109.18581073000007 -0.0936015969999744, 109.18591941100004 -0.093521424999949, 109.18602807300005 -0.09344122899995, 109.18613673300007 -0.0933610299999259, 109.18624534100007 -0.0932807599999705, 109.18635392400006 -0.0932004559999768, 109.18646243200004 -0.0931200479999461, 109.18657079200005 -0.0930394389999378, 109.18667889500006 -0.0929584799999361, 109.18678622300007 -0.092876485999966, 109.18689183300006 -0.0927922649999573, 109.18699543900004 -0.0927055549999523, 109.18709797800005 -0.0926175669999338, 109.18720044200006 -0.0925294889999577, 109.18730306700007 -0.0924416009999618, 109.18740538900005 -0.0923533549999433, 109.18750690200005 -0.0922641709999539, 109.18760686200005 -0.0921732289999682, 109.18770403300005 -0.0920792819999292, 109.18779635800007 -0.0919805209999254, 109.18788177800008 -0.0918756759999724, 109.18795802100004 -0.0917639169999802, 109.18802180000006 -0.0916445459999409, 109.18806710900009 -0.0915170079999257, 109.18808689400004 -0.0913831109999705, 109.18807746900006 -0.0912480509999796, 109.18804566500006 -0.0911163689999626, 109.18799840900004 -0.0909894119999421, 109.18799172800004 -0.0909758239999405, 109.18803756700004 -0.0909773269999619, 109.18892272700003 -0.0910772639999777, 109.18894579600004 -0.0910772639999777, 109.18946987300006 -0.0910772639999777, 109.18960801100008 -0.0910772639999777, 109.19063593800007 -0.0910344339999369, 109.19124983900008 -0.090991603999953, 109.19166386600006 -0.0909059429999388, 109.19200650800008 -0.0906775149999248, 109.19226586900004 -0.0903158369999346, 109.19281314500006 -0.0895544089999589, 109.19333543700009 -0.0890559119999352, 109.19369711500008 -0.0889416979999282, 109.19412541800006 -0.0888750729999401, 109.19478214900005 -0.0888750729999401, 109.19613368300008 -0.0888560369999709, 109.19697125300007 -0.0889036269999792, 109.19727582400009 -0.0889416979999282, 109.19785641300007 -0.0891225369999802, 109.19895096500005 -0.0893224119999445, 109.19905566100005 -0.0892938579999623, 109.19922698200008 -0.0892081979999375, 109.19964656100007 -0.0888117219999458, 109.20028187700007 -0.0882482829999276, 109.20050792600006 -0.0880817209999805, 109.20072207700008 -0.0880103369999574, 109.20305394900004 -0.0879032619999407, 109.20518356600007 -0.0877485969999725, 109.20512813900007 -0.0862782199999401, 109.20579508800006 -0.0863304379999477, 109.20571894500006 -0.0844554229999517, 109.20648989100005 -0.0845220469999504, 109.20663144700006 -0.0858166249999499, 109.20711497500008 -0.0858163159999776, 109.20759324700003 -0.0848383569999669, 109.20793588900005 -0.0848383569999669, 109.20971810500004 -0.0852785569999241, 109.21010536100005 -0.0852791199999388, 109.21141185300007 -0.0853662189999795, 109.21094782500006 -0.0834964599999353, 109.21077974700006 -0.0829201929999499, 109.21385868800007 -0.0820019129999423, 109.21371547300004 -0.0814955949999785, 109.21782718100008 -0.0812671669999645, 109.21769393200009 -0.0791542049999521, 109.21895028700004 -0.0792684199999485, 109.22242463200007 -0.0794471579999367, 109.22264431800005 -0.0794177459999332, 109.22364551400005 -0.0792837059999556, 109.22714003700008 -0.0786618259999727, 109.23574484100004 -0.0774094259999742, 109.24236587600006 -0.0764593659999377, 109.24493949100008 -0.0767038409999259, 109.24517199500008 -0.0767259269999272, 109.24606058500007 -0.0768103369999267, 109.24824968900003 -0.0767532299999516, 109.25038168600008 -0.0764486589999365, 109.25238043300004 -0.0759918029999653, 109.25873222100006 -0.0744519739999419, 109.25915935900008 -0.0744043899999269, 109.26011173200004 -0.0779679099999271, 109.26034628700006 -0.0788455519999616, 109.26359604700008 -0.0910052719999612, 109.26359675700007 -0.0910052019999625, 109.26361018400007 -0.0910517889999483, 109.26972580200004 -0.0904001059999473, 109.27309609000008 -0.0900673699999288, 109.27810269300005 -0.0895074579999573, 109.29688390600006 -0.0874070699999265, 109.29685419800006 -0.0875154159999738)))",
                    "fid_1": 19,
                    "OBJECTID": 43337,
                    "KDPPUM": 61,
                    "NAMOBJ": "Kalimas",
                    "REMARK": "",
                    "KDPBPS": "",
                    "FCODE": "BA03070040",
                    "LUASWH": 0,
                    "UUPP": "Hasil Delineasi Batas Desa 2018",
                    "SRS_ID": "SRGI 2013",
                    "METADATA": "TASWIL1000020200326DATA_BATAS_DESA_KELURAHAN",
                    "KDEBPS": 6112050004,
                    "KDEPUM": "61.12.09.2008",
                    "KDCBPS": "050",
                    "KDCPUM": "61.12.09",
                    "KDBBPS": 12,
                    "WADMKD": "Kalimas",
                    "WIADKD": "",
                    "WADMKC": "Sungai Kakap",
                    "WIADKC": "Sungai Kakap",
                    "WADMKK": "Kubu Raya",
                    "WIADKK": "Kubu Raya",
                    "WADMPR": "Kalimantan Barat",
                    "WIADPR": "Kalimantan Barat",
                    "TIPADM": 1,
                    "KDPKAB": 61.12,
                    "SHAPE_Leng": 0.27847413,
                    "SHAPE_Area": 0.0023258
                },
                "geometry": null
            }, ]
        }
    </script> --}}

    {{-- Sungai Belidak --}}


    {{-- Pal Sembilan --}}


    {{-- Punggur Kapuas --}}


    {{-- Punggu Kecil --}}
@endpush
