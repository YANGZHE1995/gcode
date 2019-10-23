<?php
/**
 * Created by PhpStorm.
 * User: HappyQi
 * Date: 2017/12/4
 * Time: 9:23
 */

namespace App\Components\Common;

use Geohash\GeoHash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Routing\Tests\Utf8RouteCompiler;

class UserInfoGenerator
{
    //头像数组
    const AVATAR_URL_ARR = [
        "http://twst.isart.me/avatar/20190102101495759774.png",
        "http://twst.isart.me/avatar/20190102100995251009.png",
        "http://twst.isart.me/avatar/20190102100551001871.png",
        "http://twst.isart.me/avatar/20190102100501023570.png",
        "http://twst.isart.me/avatar/20190102991005055571.png",
        "http://twst.isart.me/avatar/20190102995751557184.png",
        "http://twst.isart.me/avatar/20190102995148998534.png",
        "http://twst.isart.me/avatar/20190102981005052636.png",
        "http://twst.isart.me/avatar/20190102985699570681.png",
        "http://twst.isart.me/avatar/20190102984899981197.png",
        "http://twst.isart.me/avatar/20190102979948529407.png",
        "http://twst.isart.me/avatar/20190102975510152085.png",
        "http://twst.isart.me/avatar/20190102975156979932.png",
        "http://twst.isart.me/avatar/20190102561001024672.png",
        "http://twst.isart.me/avatar/20190102565797482164.png",
        "http://twst.isart.me/avatar/20190102565353985009.png",
        "http://twst.isart.me/avatar/20190102564810156357.png",
        "http://twst.isart.me/avatar/20190102559856565866.png",
        "http://twst.isart.me/avatar/20190102555457105742.png",
        "http://twst.isart.me/avatar/20190102555052555801.png",
        "http://twst.isart.me/avatar/20190102549949578150.png",
        "http://twst.isart.me/avatar/20190102545649101361.png",
        "http://twst.isart.me/avatar/20190102545057550933.png",
        "http://twst.isart.me/avatar/20190102531004911460.png",
        "http://twst.isart.me/avatar/20190102535553977552.png",
        "http://twst.isart.me/avatar/20190102534957105895.png",
        "http://twst.isart.me/avatar/20190102521005054416.png",
        "http://twst.isart.me/avatar/20190102525752536209.png",
        "http://twst.isart.me/avatar/20190102525354509409.png",
        "http://twst.isart.me/avatar/20190102524997566174.png",
        "http://twst.isart.me/avatar/20190102519898107784.png",
        "http://twst.isart.me/avatar/20190102515556498592.png",
        "http://twst.isart.me/avatar/20190102515099109633.png",
        "http://twst.isart.me/avatar/20190102501005156849.png",
        "http://twst.isart.me/avatar/20190102505698517438.png",
        "http://twst.isart.me/avatar/20190102505253572057.png",
        "http://twst.isart.me/avatar/20190102504849994453.png",
        "http://twst.isart.me/avatar/20190102499852558274.png",
        "http://twst.isart.me/avatar/20190102495548986407.png",
        "http://twst.isart.me/avatar/20190102495010154841.png",
        "http://twst.isart.me/avatar/20190102481005457286.png",
        "http://twst.isart.me/avatar/20190102485750579642.png",
        "http://twst.isart.me/avatar/20190102102100569722.png",
        "http://twst.isart.me/avatar/20190102539852542743.png",
        "http://twst.isart.me/avatar/20190102535550503431.png",
        "http://twst.isart.me/avatar/20190102535049540594.png",
        "http://twst.isart.me/avatar/20190102521004953823.png",
        "http://twst.isart.me/avatar/20190102525698540514.png",
        "http://twst.isart.me/avatar/20190102525257550460.png",
        "http://twst.isart.me/avatar/20190102524855979461.png",
        "http://twst.isart.me/avatar/20190102519798109153.png",
        "http://twst.isart.me/avatar/20190102515453496331.png",
        "http://twst.isart.me/avatar/20190102514954517554.png",
        "http://twst.isart.me/avatar/20190102509957102453.png",
        "http://twst.isart.me/avatar/20190102505654999206.png",
        "http://twst.isart.me/avatar/20190102505255515388.png",
        "http://twst.isart.me/avatar/20190102491019859759.png",
        "http://twst.isart.me/avatar/20190102499754104805.png",
        "http://twst.isart.me/avatar/20190102495454108878.png",
        "http://twst.isart.me/avatar/20190102494952100294.png",
        "http://twst.isart.me/avatar/20190102489799553104.png",
        "http://twst.isart.me/avatar/20190102485310196950.png",
        "http://twst.isart.me/avatar/20190102484951564319.png",
        "http://twst.isart.me/avatar/20190102102995517968.png",
        "http://twst.isart.me/avatar/20190102102541019643.png",
        "http://twst.isart.me/avatar/20190102102505448925.png",
        "http://twst.isart.me/avatar/20190102101100511160.png",
        "http://twst.isart.me/avatar/20190102101575040278.png",
        "http://twst.isart.me/avatar/20190102101515352586.png",
        "http://twst.isart.me/avatar/20190102100995717435.png",
        "http://twst.isart.me/avatar/20190102100565452639.png",
        "http://twst.isart.me/avatar/20190102100524847532.png",
        "http://twst.isart.me/avatar/20190102991001025420.png",
        "http://twst.isart.me/avatar/20190102985654108587.png",
        "http://twst.isart.me/avatar/20190102985199102357.png",
        "",
        "http://twst.isart.me/avatar/20190102971005442023.png",
        "http://twst.isart.me/avatar/20190102975751486545.png",
        "http://twst.isart.me/avatar/20190102975210152466.png",
        "http://twst.isart.me/avatar/20190102974899544982.png",
        "http://twst.isart.me/avatar/20190102579855995947.png",
        "http://twst.isart.me/avatar/20190102575550106879.png",
        "http://twst.isart.me/avatar/20190102575053501024.png",
        "http://twst.isart.me/avatar/20190102569954105248.png",
        "http://twst.isart.me/avatar/20190102565650537869.png",
        "http://twst.isart.me/avatar/20190102565249101958.png",
        "http://twst.isart.me/avatar/20190102551001014048.png",
        "http://twst.isart.me/avatar/20190102555797101796.png",
        "http://twst.isart.me/avatar/20190102555397987278.png",
        "http://twst.isart.me/avatar/20190102554910050756.png",
        "http://twst.isart.me/avatar/20190102549910158497.png",
        "http://twst.isart.me/avatar/20190102545653574114.png",
        "http://twst.isart.me/avatar/20190102545099494742.png",
        "http://twst.isart.me/avatar/20190102539954557032.png",
        "http://twst.isart.me/avatar/20190102535649486037.png",
        "http://twst.isart.me/avatar/20190102535110299515.png",
        "http://twst.isart.me/avatar/20190102521011008201.png",
        "http://twst.isart.me/avatar/20190102529752992940.png",
        "http://twst.isart.me/avatar/20190102525457104148.png",
        "http://twst.isart.me/avatar/20190102525052547057.png",
        "http://twst.isart.me/avatar/20190102511005253258.png",
        "http://twst.isart.me/avatar/20190102515755104296.png",
        "http://twst.isart.me/avatar/20190102515353483308.png",
        "http://twst.isart.me/avatar/20190102509999107145.png",
        "http://twst.isart.me/avatar/20190102975249507851.png",
        "http://twst.isart.me/avatar/20190102571019716596.png",
        "http://twst.isart.me/avatar/20190102579754991329.png",
        "http://twst.isart.me/avatar/20190102575450576089.png",
        "http://twst.isart.me/avatar/20190102575052542097.png",
        "http://twst.isart.me/avatar/20190102569910296339.png",
        "http://twst.isart.me/avatar/20190102565650514367.png",
        "http://twst.isart.me/avatar/20190102565152554225.png",
        "http://twst.isart.me/avatar/20190102551005417101.png",
        "http://twst.isart.me/avatar/20190102555749569885.png",
        "http://twst.isart.me/avatar/20190102555256559950.png",
        "http://twst.isart.me/avatar/20190102554855508184.png",
        "http://twst.isart.me/avatar/20190102549898992412.png",
        "http://twst.isart.me/avatar/20190102545599566465.png",
        "http://twst.isart.me/avatar/20190102544897504252.png",
        "http://twst.isart.me/avatar/20190102539897106666.png",
        "http://twst.isart.me/avatar/20190102535553522725.png",
        "http://twst.isart.me/avatar/20190102534910293348.png",
        "http://twst.isart.me/avatar/20190102521004818953.png",
        "http://twst.isart.me/avatar/20190102525752568513.png",
        "http://twst.isart.me/avatar/20190102525210297588.png",
        "http://twst.isart.me/avatar/20190102524899985180.png",
        "http://twst.isart.me/avatar/20190102519854554785.png",
        "http://twst.isart.me/avatar/20190102515552105404.png",
        "http://twst.isart.me/avatar/20190102515099974870.png",
        "http://twst.isart.me/avatar/20190102501001017286.png",
        "http://twst.isart.me/avatar/20190102505757973438.png",
        "http://twst.isart.me/avatar/20190102505353972912.png",
        "http://twst.isart.me/avatar/20190102504951103038.png",
        "http://twst.isart.me/avatar/20190102499855989392.png",
        "http://twst.isart.me/avatar/20190102485456986604.png",
        "http://twst.isart.me/avatar/20190102484952484928.png",
        "http://twst.isart.me/avatar/20190102102985696195.png",
        "http://twst.isart.me/avatar/20190102102555612925.png",
        "http://twst.isart.me/avatar/20190102102515553711.png",
        "http://twst.isart.me/avatar/20190102101101557043.png",
        "http://twst.isart.me/avatar/20190102101574890329.png",
        "http://twst.isart.me/avatar/20190102101521008658.png",
        "http://twst.isart.me/avatar/20190102100101552508.png",
        "http://twst.isart.me/avatar/20190102100974956140.png",
        "http://twst.isart.me/avatar/20190102100521019219.png",
        "http://twst.isart.me/avatar/20190102100489959258.png",
        "http://twst.isart.me/avatar/20190102999854574464.png",
        "http://twst.isart.me/avatar/20190102995497540108.png",
        "http://twst.isart.me/avatar/20190102995098536921.png",
        "http://twst.isart.me/avatar/20190102981009797185.png",
        "http://twst.isart.me/avatar/20190102985651976437.png",
        "http://twst.isart.me/avatar/20190102985099556346.png",
        "http://twst.isart.me/avatar/20190102971005759085.png",
        "http://twst.isart.me/avatar/20190102975756512138.png",
        "http://twst.isart.me/avatar/20190102975110154307.png",
        "http://twst.isart.me/avatar/20190102571005551563.png",
        "http://twst.isart.me/avatar/20190102575653576814.png",
        "http://twst.isart.me/avatar/20190102575110256801.png",
        "http://twst.isart.me/avatar/20190102561025059797.png",
        "http://twst.isart.me/avatar/20190102569710055777.png",
        "http://twst.isart.me/avatar/20190102565448537740.png",
        "http://twst.isart.me/avatar/20190102564999532940.png",
        "http://twst.isart.me/avatar/20190102559999100796.png",
        "http://twst.isart.me/avatar/20190102555148563696.png",
        "http://twst.isart.me/avatar/20190102100971011064.png",
        "http://twst.isart.me/avatar/20190102100549816703.png",
        "http://twst.isart.me/avatar/20190102100504851509.png",
        "http://twst.isart.me/avatar/20190102999853495083.png",
        "http://twst.isart.me/avatar/20190102995553106378.png",
        "http://twst.isart.me/avatar/20190102995010258631.png",
        "http://twst.isart.me/avatar/20190102981015110188.png",
        "http://twst.isart.me/avatar/20190102989750109330.png",
        "http://twst.isart.me/avatar/20190102985310017623.png",
        "http://twst.isart.me/avatar/20190102984948997422.png",
        "http://twst.isart.me/avatar/20190102979951985730.png",
        "http://twst.isart.me/avatar/20190102975555983821.png",
        "http://twst.isart.me/avatar/20190102975153990957.png",
        "http://twst.isart.me/avatar/20190102571015457765.png",
        "http://twst.isart.me/avatar/20190102579756551223.png",
        "http://twst.isart.me/avatar/20190102575450518581.png",
        "http://twst.isart.me/avatar/20190102561009999719.png",
        "http://twst.isart.me/avatar/20190102565797105626.png",
        "http://twst.isart.me/avatar/20190102565351971428.png",
        "http://twst.isart.me/avatar/20190102564856979016.png",
        "http://twst.isart.me/avatar/20190102559848497867.png",
        "http://twst.isart.me/avatar/20190102555548551522.png",
        "http://twst.isart.me/avatar/20190102555099981454.png",
        "",
        "http://twst.isart.me/avatar/20190102541005652949.png",
        "http://twst.isart.me/avatar/20190102545757100386.png",
        "http://twst.isart.me/avatar/20190102545298977022.png",
        "http://twst.isart.me/avatar/20190102544849985780.png",
        "http://twst.isart.me/avatar/20190102539857106760.png",
        "http://twst.isart.me/avatar/20190102535552525789.png",
        "http://twst.isart.me/avatar/20190102535010151359.png",
        "http://twst.isart.me/avatar/20190102519910058000.png",
        "http://twst.isart.me/avatar/20190102515510054815.png",
        "http://twst.isart.me/avatar/20190102515152103888.png",
        "http://twst.isart.me/avatar/20190102501015459973.png",
        "http://twst.isart.me/avatar/20190102505710194596.png",
        "http://twst.isart.me/avatar/20190102505297984187.png",
        "http://twst.isart.me/avatar/20190102504853107953.png",
        "http://twst.isart.me/avatar/20190102499852534882.png",
        "http://twst.isart.me/avatar/20190102495410257624.png",
        "http://twst.isart.me/avatar/20190102495010157535.png",
        "http://twst.isart.me/avatar/20190102481001020574.png",
        "http://twst.isart.me/avatar/20190102485710051278.png",
        "http://twst.isart.me/avatar/20190102485357109665.png",
        "http://twst.isart.me/avatar/20190102484999512376.png",
        "http://twst.isart.me/avatar/20190102102995593103.png",
        "http://twst.isart.me/avatar/20190102102565014456.png",
        "http://twst.isart.me/avatar/20190102102519859820.png",
        "http://twst.isart.me/avatar/20190102101101105451.png",
        "http://twst.isart.me/avatar/20190102101571012234.png",
        "http://twst.isart.me/avatar/20190102101534810611.png",
        "http://twst.isart.me/avatar/20190102101485352183.png",
        "http://twst.isart.me/avatar/20190102100989755935.png",
        "http://twst.isart.me/avatar/20190102100555111730.png",
        "http://twst.isart.me/avatar/20190102100501029822.png",
        "http://twst.isart.me/avatar/20190102991001015353.png",
        "http://twst.isart.me/avatar/20190102995798577676.png",
        "http://twst.isart.me/avatar/20190102995354995799.png",
        "http://twst.isart.me/avatar/20190102994848100560.png",
        "http://twst.isart.me/avatar/20190102989854541261.png",
        "http://twst.isart.me/avatar/20190102985153984010.png",
        "http://twst.isart.me/avatar/20190102489799107012.png",
        "http://twst.isart.me/avatar/20190102485355501996.png",
        "http://twst.isart.me/avatar/20190102484899103979.png",
        "http://twst.isart.me/avatar/20190102102994850115.png",
        "http://twst.isart.me/avatar/20190102102555313259.png",
        "http://twst.isart.me/avatar/20190102102501019195.png",
        "http://twst.isart.me/avatar/20190102101100107136.png",
        "http://twst.isart.me/avatar/20190102101575353220.png",
        "http://twst.isart.me/avatar/20190102101535419801.png",
        "http://twst.isart.me/avatar/20190102101495295735.png",
        "http://twst.isart.me/avatar/20190102100981023477.png",
        "http://twst.isart.me/avatar/20190102100555648511.png",
        "http://twst.isart.me/avatar/20190102100514990531.png",
        "http://twst.isart.me/avatar/20190102991015051656.png",
        "http://twst.isart.me/avatar/20190102999749106303.png",
        "http://twst.isart.me/avatar/20190102995349566979.png",
        "http://twst.isart.me/avatar/20190102994810151989.png",
        "http://twst.isart.me/avatar/20190102989753502872.png",
        "http://twst.isart.me/avatar/20190102985448979871.png",
        "http://twst.isart.me/avatar/20190102984999100028.png",
        "http://twst.isart.me/avatar/20190102979910249707.png",
        "http://twst.isart.me/avatar/20190102975657103264.png",
        "http://twst.isart.me/avatar/20190102975297983210.png",
        "http://twst.isart.me/avatar/20190102974897105753.png",
        "http://twst.isart.me/avatar/20190102579810251782.png",
        "http://twst.isart.me/avatar/20190102575550527242.png",
        "http://twst.isart.me/avatar/20190102575010253787.png",
        "http://twst.isart.me/avatar/20190102561005692375.png",
        "http://twst.isart.me/avatar/20190102565799105844.png",
        "http://twst.isart.me/avatar/20190102565397106919.png",
        "http://twst.isart.me/avatar/20190102541025099644.png",
        "http://twst.isart.me/avatar/20190102549757538665.png",
        "http://twst.isart.me/avatar/20190102545210057400.png",
        "http://twst.isart.me/avatar/20190102544851500807.png",
        "http://twst.isart.me/avatar/20190102539852973768.png",
        "http://twst.isart.me/avatar/20190102535451995727.png",
        "http://twst.isart.me/avatar/20190102535055549248.png",
        "http://twst.isart.me/avatar/20190102521005559123.png",
        "http://twst.isart.me/avatar/20190102525750109847.png",
        "http://twst.isart.me/avatar/20190102525155559020.png",
        "http://twst.isart.me/avatar/20190102511015747191.png",
        "http://twst.isart.me/avatar/20190102519710096026.png",
        "http://twst.isart.me/avatar/20190102515453107761.png",
        "http://twst.isart.me/avatar/20190102515052507210.png",
        "http://twst.isart.me/avatar/20190102501005249238.png",
        "http://twst.isart.me/avatar/20190102505749539251.png",
        "http://twst.isart.me/avatar/20190102505252482082.png",
        "http://twst.isart.me/avatar/20190102504850503152.png",
        "http://twst.isart.me/avatar/20190102499757528977.png",
        "http://twst.isart.me/avatar/20190102495457517806.png",
        "http://twst.isart.me/avatar/20190102494955976529.png",
        "http://twst.isart.me/avatar/20190102489956981557.png",
        "http://twst.isart.me/avatar/20190102485653100045.png",
        "http://twst.isart.me/avatar/20190102485110254119.png",
        "http://twst.isart.me/avatar/20190102484848530020.png",
        "http://twst.isart.me/avatar/20190102102985359898.png",
        "http://twst.isart.me/avatar/20190102102521020474.png",
        "http://twst.isart.me/avatar/20190102102489896433.png",
        "http://twst.isart.me/avatar/20190102101994857569.png",
        "http://twst.isart.me/avatar/20190102101524898146.png",
        "http://twst.isart.me/avatar/20190102559797495976.png",
        "http://twst.isart.me/avatar/20190102555310055768.png",
        "http://twst.isart.me/avatar/20190102554910150806.png",
        "http://twst.isart.me/avatar/20190102541005116888.png",
        "http://twst.isart.me/avatar/20190102545751988754.png",
        "http://twst.isart.me/avatar/20190102545257973625.png",
        "http://twst.isart.me/avatar/20190102544897542027.png",
        "http://twst.isart.me/avatar/20190102539897521030.png",
        "http://twst.isart.me/avatar/20190102535550491092.png",
        "http://twst.isart.me/avatar/20190102535051108721.png",
        "http://twst.isart.me/avatar/20190102521005592723.png",
        "http://twst.isart.me/avatar/20190102525753515838.png",
        "http://twst.isart.me/avatar/20190102525299530885.png",
        "http://twst.isart.me/avatar/20190102524897511418.png",
        "http://twst.isart.me/avatar/20190102519857489670.png",
        "http://twst.isart.me/avatar/20190102515549520951.png",
        "http://twst.isart.me/avatar/20190102514997101032.png",
        "http://twst.isart.me/avatar/20190102509998514720.png",
        "http://twst.isart.me/avatar/20190102505655982798.png",
        "http://twst.isart.me/avatar/20190102505297982665.png",
        "",
        "http://twst.isart.me/avatar/20190102491024815807.png",
        "http://twst.isart.me/avatar/20190102499757105376.png",
        "http://twst.isart.me/avatar/20190102495457540764.png",
        "http://twst.isart.me/avatar/20190102494957495272.png",
        "http://twst.isart.me/avatar/20190102489956106975.png",
        "http://twst.isart.me/avatar/20190102485510253368.png",
        "http://twst.isart.me/avatar/20190102485248531625.png",
        "http://twst.isart.me/avatar/20190102102101485050.png",
        "http://twst.isart.me/avatar/20190102102565095264.png",
        "http://twst.isart.me/avatar/20190102102519854952.png",
        "http://twst.isart.me/avatar/20190102100100557921.png",
        "http://twst.isart.me/avatar/20190102100575458848.png",
        "http://twst.isart.me/avatar/20190102100534956452.png",
        "http://twst.isart.me/avatar/20190102100481024853.png",
        "http://twst.isart.me/avatar/20190102999849104601.png",
        "http://twst.isart.me/avatar/20190102995455977593.png",
        "http://twst.isart.me/avatar/20190102994956101252.png",
        "http://twst.isart.me/avatar/20190102989952559928.png",
        "http://twst.isart.me/avatar/20190102985648521858.png",
        "http://twst.isart.me/avatar/20190102985097504136.png",
        "http://twst.isart.me/avatar/20190102979955535134.png",
        "http://twst.isart.me/avatar/20190102975650100452.png",
        "http://twst.isart.me/avatar/20190102975010094035.png",
        "http://twst.isart.me/avatar/20190102571005396849.png",
        "http://twst.isart.me/avatar/20190102575753558860.png",
        "http://twst.isart.me/avatar/20190102575351551145.png",
        "http://twst.isart.me/avatar/20190102574898509381.png",
        "http://twst.isart.me/avatar/20190102569810040584.png",
        "http://twst.isart.me/avatar/20190102565548105984.png",
        "http://twst.isart.me/avatar/20190102565010254164.png",
        "http://twst.isart.me/avatar/20190102551001015166.png",
        "http://twst.isart.me/avatar/20190102555698513128.png",
        "http://twst.isart.me/avatar/20190102555252533080.png",
        "http://twst.isart.me/avatar/20190102541024851438.png",
        "http://twst.isart.me/avatar/20190102549798107408.png",
        "http://twst.isart.me/avatar/20190102545451509935.png",
        "http://twst.isart.me/avatar/20190102544999569737.png",
        "http://twst.isart.me/avatar/20190102535751545605.png",
        "http://twst.isart.me/avatar/20190102535348542941.png",
        "http://twst.isart.me/avatar/20190102529810210470.png",
        "http://twst.isart.me/avatar/20190102579757101601.png",
        "http://twst.isart.me/avatar/20190102575357560478.png",
        "http://twst.isart.me/avatar/20190102574856100820.png",
        "http://twst.isart.me/avatar/20190102569850574671.png",
        "http://twst.isart.me/avatar/20190102565453483794.png",
        "http://twst.isart.me/avatar/20190102564910211624.png",
        "http://twst.isart.me/avatar/20190102559910214854.png",
        "http://twst.isart.me/avatar/20190102555554494840.png",
        "http://twst.isart.me/avatar/20190102555198568993.png",
        "http://twst.isart.me/avatar/20190102541011015294.png",
        "http://twst.isart.me/avatar/20190102549750549084.png",
        "http://twst.isart.me/avatar/20190102545450523107.png",
        "http://twst.isart.me/avatar/20190102544910244536.png",
        "http://twst.isart.me/avatar/20190102531004847321.png",
        "http://twst.isart.me/avatar/20190102535651990551.png",
        "http://twst.isart.me/avatar/20190102535248508579.png",
        "http://twst.isart.me/avatar/20190102521024998165.png",
        "http://twst.isart.me/avatar/20190102525752981946.png",
        "http://twst.isart.me/avatar/20190102525355490973.png",
        "http://twst.isart.me/avatar/20190102524948552454.png",
        "http://twst.isart.me/avatar/20190102519950521379.png",
        "http://twst.isart.me/avatar/20190102515654563046.png",
        "http://twst.isart.me/avatar/20190102515156104040.png",
        "http://twst.isart.me/avatar/20190102501015316603.png",
        "http://twst.isart.me/avatar/20190102509750540057.png",
        "http://twst.isart.me/avatar/20190102505310155466.png",
        "http://twst.isart.me/avatar/20190102504856565480.png",
        "http://twst.isart.me/avatar/20190102499854543263.png",
        "http://twst.isart.me/avatar/20190102495555986067.png",
        "http://twst.isart.me/avatar/20190102495052500584.png",
        "http://twst.isart.me/avatar/20190102102979893460.png",
        "http://twst.isart.me/avatar/20190102102545316544.png",
        "http://twst.isart.me/avatar/20190102102495546493.png",
        "http://twst.isart.me/avatar/20190102101995055926.png",
        "http://twst.isart.me/avatar/20190102101551017408.png",
        "http://twst.isart.me/avatar/20190102101514998655.png",
        "http://twst.isart.me/avatar/20190102100101517734.png",
        "http://twst.isart.me/avatar/20190102100575356245.png",
        "http://twst.isart.me/avatar/20190102100535451678.png",
        "http://twst.isart.me/avatar/20190102100495056622.png",
        "http://twst.isart.me/avatar/20190102999710058520.png",
        "http://twst.isart.me/avatar/20190102995456537181.png",
        "http://twst.isart.me/avatar/20190102995052495826.png",
        "http://twst.isart.me/avatar/20190102989997539795.png",
        "http://twst.isart.me/avatar/20190102985656101002.png",
        "http://twst.isart.me/avatar/20190102985199575539.png",
        "http://twst.isart.me/avatar/20190102971024815623.png",
        "http://twst.isart.me/avatar/20190102979797994106.png",
        "http://twst.isart.me/avatar/20190102975451533470.png",
        "http://twst.isart.me/avatar/20190102974810252799.png",
        "http://twst.isart.me/avatar/20190102579810244496.png",
        "http://twst.isart.me/avatar/20190102575557105974.png",
        "http://twst.isart.me/avatar/20190102574910250359.png",
        "http://twst.isart.me/avatar/20190102561005110185.png",
        "http://twst.isart.me/avatar/20190102565610143161.png",
        "http://twst.isart.me/avatar/20190102565253104065.png",
        "http://twst.isart.me/avatar/20190102551015658604.png",
        "http://twst.isart.me/avatar/20190102555710190971.png",
        "http://twst.isart.me/avatar/20190102555397562465.png",
        "http://twst.isart.me/avatar/20190102549810259513.png",
        "http://twst.isart.me/avatar/20190102100515117238.png",
        "http://twst.isart.me/avatar/20190102991001018513.png",
        "http://twst.isart.me/avatar/20190102995748528582.png",
        "http://twst.isart.me/avatar/20190102995252522671.png",
        "http://twst.isart.me/avatar/20190102994853519103.png",
        "http://twst.isart.me/avatar/20190102989797102863.png",
        "http://twst.isart.me/avatar/20190102985451569648.png",
        "http://twst.isart.me/avatar/20190102984997509897.png",
        "http://twst.isart.me/avatar/20190102979997557037.png",
        "http://twst.isart.me/avatar/20190102975654109789.png",
        "http://twst.isart.me/avatar/20190102975254558865.png",
        "http://twst.isart.me/avatar/20190102571019813411.png",
        "http://twst.isart.me/avatar/20190102579797510584.png",
        "http://twst.isart.me/avatar/20190102575450107746.png",
        "http://twst.isart.me/avatar/20190102574910092374.png",
        "http://twst.isart.me/avatar/20190102561004892360.png",
        "http://twst.isart.me/avatar/20190102565657492791.png",
        "http://twst.isart.me/avatar/20190102565150509533.png",
        "http://twst.isart.me/avatar/20190102551001005681.png",
        "http://twst.isart.me/avatar/20190102555755515748.png",
        "http://twst.isart.me/avatar/20190102555352524565.png",
        "http://twst.isart.me/avatar/20190102554948495173.png",
        "http://twst.isart.me/avatar/20190102549949562797.png",
        "http://twst.isart.me/avatar/20190102545557995554.png",
        "http://twst.isart.me/avatar/20190102545150560949.png",
        "http://twst.isart.me/avatar/20190102531015458253.png",
        "http://twst.isart.me/avatar/20190102535710191929.png",
        "http://twst.isart.me/avatar/20190102535310152268.png",
        "http://twst.isart.me/avatar/20190102534957997806.png",
        "http://twst.isart.me/avatar/20190102529999537069.png",
        "http://twst.isart.me/avatar/20190102515554571782.png",
        "http://twst.isart.me/avatar/20190102515154504334.png",
        "http://twst.isart.me/avatar/20190102501015359844.png",
        "http://twst.isart.me/avatar/20190102505756556578.png",
        "http://twst.isart.me/avatar/20190102505298105476.png",
        "http://twst.isart.me/avatar/20190102504851552740.png",
        "http://twst.isart.me/avatar/20190102499854491906.png",
        "http://twst.isart.me/avatar/20190102495549971064.png",
        "http://twst.isart.me/avatar/20190102495098526977.png",
        "http://twst.isart.me/avatar/20190102481004955243.png",
        "http://twst.isart.me/avatar/20190102485655522678.png",
        "http://twst.isart.me/avatar/20190102485148106282.png",
        "http://twst.isart.me/avatar/20190102102100102267.png",
        "http://twst.isart.me/avatar/20190102102575553612.png",
        "http://twst.isart.me/avatar/20190102102525157960.png",
        "http://twst.isart.me/avatar/20190102101101108492.png",
        "http://twst.isart.me/avatar/20190102101979791328.png",
        "http://twst.isart.me/avatar/20190102101549853926.png",
        "http://twst.isart.me/avatar/20190102101505050958.png",
        "http://twst.isart.me/avatar/20190102100100494038.png",
        "http://twst.isart.me/avatar/20190102100575255465.png",
        "http://twst.isart.me/avatar/20190102100514853200.png",
        "http://twst.isart.me/avatar/20190102991005446511.png",
        "http://twst.isart.me/avatar/20190102995651522662.png",
        "http://twst.isart.me/avatar/20190102995252971262.png",
        "http://twst.isart.me/avatar/20190102981025159578.png",
        "http://twst.isart.me/avatar/20190102989850522819.png",
        "http://twst.isart.me/avatar/20190102985548993463.png",
        "http://twst.isart.me/avatar/20190102985152545259.png",
        "http://twst.isart.me/avatar/20190102979752499762.png",
        "http://twst.isart.me/avatar/20190102504810255571.png",
        "http://twst.isart.me/avatar/20190102499756523622.png",
        "http://twst.isart.me/avatar/20190102495357490008.png",
        "http://twst.isart.me/avatar/20190102481019756071.png",
        "http://twst.isart.me/avatar/20190102489710018259.png",
        "http://twst.isart.me/avatar/20190102485498481634.png",
        "http://twst.isart.me/avatar/20190102485050109222.png",
        "http://twst.isart.me/avatar/20190102102995297038.png",
        "http://twst.isart.me/avatar/20190102102554856770.png",
        "http://twst.isart.me/avatar/20190102102495652988.png",
        "http://twst.isart.me/avatar/20190102101995746255.png",
        "http://twst.isart.me/avatar/20190102101565398500.png",
        "http://twst.isart.me/avatar/20190102101525153214.png",
        "http://twst.isart.me/avatar/20190102100101571690.png",
        "http://twst.isart.me/avatar/20190102100975793419.png",
        "http://twst.isart.me/avatar/20190102100545257278.png",
        "http://twst.isart.me/avatar/20190102100505154977.png",
        "http://twst.isart.me/avatar/20190102991005296627.png",
        "http://twst.isart.me/avatar/20190102995748996232.png",
        "http://twst.isart.me/avatar/20190102995110052940.png",
    ];

    //昵称数组
    const SIGN_ARR = [
        "喜欢是乍见之欢，爱是处久不厌",
        "人世间有百媚千红，唯独你是我情之独钟",
        "春风得意马蹄疾，扶摇直上九万里",
        "回眸一眼，惊鸿一瞥，便一眼万年",
        "千秋水，竹马道，一眼见你，万物不及",
        "星光不问赶路人，时光不负有心人",
        "我的爱意与世间灯火长明",
        "愿十七岁的喜欢，仍是七十岁的陪伴",
        "任时光飞逝，你依旧是我心中的超人",
        "余生漫漫，爱有归期",
        "把自己过成诗，最简单也最精致",
        "无尽虚拟的芳华，终究不敌你一笑",
        "书生翩翩风流，佳人独坐楼阁",
        "人间七月，皆是想你的日日夜夜",
        "一眼即是万年，一眼便是一世",
        "今夜还吹着风，想起你好温柔",
        "我太喜欢一把拉到怀里的拥抱",
        "时光不老，我们不散",
        "风也飘飘，雨也萧萧，流光容易把人抛",
        "山高水长，你能来已是万幸",
        "岁月是慢性流浪，远方依然是远方",
        "希望听到你的消息，我可以波澜不惊",
        "最好的关系，有幸遇见，恰好合拍",
        "海上月是天上月，眼前人是心上人",
        "诗人依赖月亮，而我只想依赖你",
        "我走过的每条路都有你的影子",
    ];

    //昵称数组
    const NICK_NAME_PART1 = ['快乐的', '冷静的', '醉熏的', '潇洒的', '糊涂的', '积极的', '冷酷的', '深情的', '粗暴的', '温柔的', '可爱的', '愉快的', '义气的', '认真的', '威武的', '帅气的', '传统的', '潇洒的', '漂亮的', '自然的', '专一的', '听话的', '昏睡的', '狂野的', '等待的', '搞怪的', '幽默的', '魁梧的', '活泼的', '开心的', '高兴的', '超帅的', '留胡子的', '坦率的', '直率的', '轻松的', '痴情的', '完美的', '精明的', '无聊的', '有魅力的', '丰富的', '繁荣的', '饱满的', '炙热的', '暴躁的', '碧蓝的', '俊逸的', '英勇的', '健忘的', '故意的', '无心的', '土豪的', '朴实的', '兴奋的', '幸福的', '淡定的', '不安的', '阔达的', '孤独的', '独特的', '疯狂的', '时尚的', '落后的', '风趣的', '忧伤的', '大胆的', '爱笑的', '矮小的', '健康的', '合适的', '玩命的', '沉默的', '斯文的', '香蕉', '苹果', '鲤鱼', '鳗鱼', '任性的', '细心的', '粗心的', '大意的', '甜甜的', '酷酷的', '健壮的', '英俊的', '霸气的', '阳光的', '默默的', '大力的', '孝顺的', '忧虑的', '着急的', '紧张的', '善良的', '凶狠的', '害怕的', '重要的', '危机的', '欢喜的', '欣慰的', '满意的', '跳跃的', '诚心的', '称心的', '如意的', '怡然的', '娇气的', '无奈的', '无语的', '激动的', '愤怒的', '美好的', '感动的', '激情的', '激昂的', '震动的', '虚拟的', '超级的', '寒冷的', '精明的', '明理的', '犹豫的', '忧郁的', '寂寞的', '奋斗的', '勤奋的', '现代的', '过时的', '稳重的', '热情的', '含蓄的', '开放的', '无辜的', '多情的', '纯真的', '拉长的', '热心的', '从容的', '体贴的', '风中的', '曾经的', '追寻的', '儒雅的', '优雅的', '开朗的', '外向的', '内向的', '清爽的', '文艺的', '长情的', '平常的', '单身的', '伶俐的', '高大的', '懦弱的', '柔弱的', '爱笑的', '乐观的', '耍酷的', '酷炫的', '神勇的', '年轻的', '唠叨的', '瘦瘦的', '无情的', '包容的', '顺心的', '畅快的', '舒适的', '靓丽的', '负责的', '背后的', '简单的', '谦让的', '彩色的', '缥缈的', '欢呼的', '生动的', '复杂的', '慈祥的', '仁爱的', '魔幻的', '虚幻的', '淡然的', '受伤的', '雪白的', '高高的', '糟糕的', '顺利的', '闪闪的', '羞涩的', '缓慢的', '迅速的', '优秀的', '聪明的', '含糊的', '俏皮的', '淡淡的', '坚强的', '平淡的', '欣喜的', '能干的', '灵巧的', '友好的', '机智的', '机灵的', '正直的', '谨慎的', '俭朴的', '殷勤的', '虚心的', '辛勤的', '自觉的', '无私的', '无限的', '踏实的', '老实的', '现实的', '可靠的', '务实的', '拼搏的', '个性的', '粗犷的', '活力的', '成就的', '勤劳的', '单纯的', '落寞的', '朴素的', '悲凉的', '忧心的', '洁净的', '清秀的', '自由的', '小巧的', '单薄的', '贪玩的', '刻苦的', '干净的', '壮观的', '和谐的', '文静的', '调皮的', '害羞的', '安详的', '自信的', '端庄的', '坚定的', '美满的', '舒心的', '温暖的', '专注的', '勤恳的', '美丽的', '腼腆的', '优美的', '甜美的', '甜蜜的', '整齐的', '动人的', '典雅的', '尊敬的', '舒服的', '妩媚的', '秀丽的', '喜悦的', '甜美的', '彪壮的', '强健的', '大方的', '俊秀的', '聪慧的', '迷人的', '陶醉的', '悦耳的', '动听的', '明亮的', '结实的', '魁梧的', '标致的', '清脆的', '敏感的', '光亮的', '大气的', '老迟到的', '知性的', '冷傲的', '呆萌的', '野性的', '隐形的', '笑点低的', '微笑的', '笨笨的', '难过的', '沉静的', '火星上的', '失眠的', '安静的', '纯情的', '要减肥的', '迷路的', '烂漫的', '哭泣的', '贤惠的', '苗条的', '温婉的', '发嗲的', '会撒娇的', '贪玩的', '执着的', '眯眯眼的', '花痴的', '想人陪的', '眼睛大的', '高贵的', '傲娇的', '心灵美的', '爱撒娇的', '细腻的', '天真的', '怕黑的', '感性的', '飘逸的', '怕孤独的', '忐忑的', '高挑的', '傻傻的', '冷艳的', '爱听歌的', '还单身的', '怕孤单的', '懵懂的'];
    const NICK_NAME_PART2 = ['嚓茶', '凉面', '便当', '毛豆', '花生', '可乐', '灯泡', '哈密瓜', '野狼', '背包', '眼神', '缘分', '雪碧', '人生', '牛排', '蚂蚁', '飞鸟', '灰狼', '斑马', '汉堡', '悟空', '巨人', '绿茶', '自行车', '保温杯', '大碗', '墨镜', '魔镜', '煎饼', '月饼', '月亮', '星星', '芝麻', '啤酒', '玫瑰', '大叔', '小伙', '哈密瓜，数据线', '太阳', '树叶', '芹菜', '黄蜂', '蜜粉', '蜜蜂', '信封', '西装', '外套', '裙子', '大象', '猫咪', '母鸡', '路灯', '蓝天', '白云', '星月', '彩虹', '微笑', '摩托', '板栗', '高山', '大地', '大树', '电灯胆', '砖头', '楼房', '水池', '鸡翅', '蜻蜓', '红牛', '咖啡', '机器猫', '枕头', '大船', '诺言', '钢笔', '刺猬', '天空', '飞机', '大炮', '冬天', '洋葱', '春天', '夏天', '秋天', '冬日', '航空', '毛衣', '豌豆', '黑米', '玉米', '眼睛', '老鼠', '白羊', '帅哥', '美女', '季节', '鲜花', '服饰', '裙子', '白开水', '秀发', '大山', '火车', '汽车', '歌曲', '舞蹈', '老师', '导师', '方盒', '大米', '麦片', '水杯', '水壶', '手套', '鞋子', '自行车', '鼠标', '手机', '电脑', '书本', '奇迹', '身影', '香烟', '夕阳', '台灯', '宝贝', '未来', '皮带', '钥匙', '心锁', '故事', '花瓣', '滑板', '画笔', '画板', '学姐', '店员', '电源', '饼干', '宝马', '过客', '大白', '时光', '石头', '钻石', '河马', '犀牛', '西牛', '绿草', '抽屉', '柜子', '往事', '寒风', '路人', '橘子', '耳机', '鸵鸟', '朋友', '苗条', '铅笔', '钢笔', '硬币', '热狗', '大侠', '御姐', '萝莉', '毛巾', '期待', '盼望', '白昼', '黑夜', '大门', '黑裤', '钢铁侠', '哑铃', '板凳', '枫叶', '荷花', '乌龟', '仙人掌', '衬衫', '大神', '草丛', '早晨', '心情', '茉莉', '流沙', '蜗牛', '战斗机', '冥王星', '猎豹', '棒球', '篮球', '乐曲', '电话', '网络', '世界', '中心', '鱼', '鸡', '狗', '老虎', '鸭子', '雨', '羽毛', '翅膀', '外套', '火', '丝袜', '书包', '钢笔', '冷风', '八宝粥', '烤鸡', '大雁', '音响', '招牌', '胡萝卜', '冰棍', '帽子', '菠萝', '蛋挞', '香水', '泥猴桃', '吐司', '溪流', '黄豆', '樱桃', '小鸽子', '小蝴蝶', '爆米花', '花卷', '小鸭子', '小海豚', '日记本', '小熊猫', '小懒猪', '小懒虫', '荔枝', '镜子', '曲奇', '金针菇', '小松鼠', '小虾米', '酒窝', '紫菜', '金鱼', '柚子', '果汁', '百褶裙', '项链', '帆布鞋', '火龙果', '奇异果', '煎蛋', '唇彩', '小土豆', '高跟鞋', '戒指', '雪糕', '睫毛', '铃铛', '手链', '香氛', '红酒', '月光', '酸奶', '银耳汤', '咖啡豆', '小蜜蜂', '小蚂蚁', '蜡烛', '棉花糖', '向日葵', '水蜜桃', '小蝴蝶', '小刺猬', '小丸子', '指甲油', '康乃馨', '糖豆', '薯片', '口红', '超短裙', '乌冬面', '冰淇淋', '棒棒糖', '长颈鹿', '豆芽', '发箍', '发卡', '发夹', '发带', '铃铛', '小馒头', '小笼包', '小甜瓜', '冬瓜', '香菇', '小兔子', '含羞草', '短靴', '睫毛膏', '小蘑菇', '跳跳糖', '小白菜', '草莓', '柠檬', '月饼', '百合', '纸鹤', '小天鹅', '云朵', '芒果', '面包', '海燕', '小猫咪', '龙猫', '唇膏', '鞋垫', '羊', '黑猫', '白猫', '万宝路', '金毛', '山水', '音响'];

    //手机号前缀
    const PHONENUM_PREFIX = [130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 144, 147,
        150, 151, 152, 153, 155, 156, 157, 158, 159,
        176, 177, 178, 180, 181, 182, 183, 184, 185, 186, 187, 188, 189,];


    //

    //获取头像
    public static function getAvatar()
    {
        return self::AVATAR_URL_ARR[array_rand(self::AVATAR_URL_ARR)];
    }

    //获取昵称
    public static function getNickName()
    {
        return self::NICK_NAME_PART1[array_rand(self::NICK_NAME_PART1)] . self::NICK_NAME_PART2[array_rand(self::NICK_NAME_PART2)];
    }

    //获取手机号
    public static function getPhonenum()
    {
        return self::PHONENUM_PREFIX[array_rand(self::PHONENUM_PREFIX)] . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
    }

    //随机生成生日
    public static function getBirthday()
    {
        $today = DateTool::getToday();
        $days_num = rand(6000, 14000);
        $birthday = DateTool::dateAdd('D', (0 - $days_num), $today);
        return $birthday;
    }

    //随机获得性别
    public static function getGender()
    {
        return rand(0, 2);
    }

    /*
     * 生成数字串
     *
     */
    public static function getCode($num)
    {
        $code = "";
        for ($i = 0; $i < $num; $i++) {
            $code = $code . rand(0, 9);
        }
        return $code;
    }

}