<!--Copy and paste into your HTML just above the close </BODY> tag. -->

<script language="JavaScript1.2">
<!-- Begin
/*
Float Up Drifter - JavaScript
Visit www.rainbow.arch.scriptmania.com/scripts/index.html
  for this script and many more
*/
    // Configure below - change number of images to render
var no = 8; 
    // Configure speed below
var speed = 20;   // The smaller the number, the faster the movement

var floatr = new Array();
   //  Your image location
floatr[0] = "balloon0.gif"
floatr[1] = "balloon1.gif"
floatr[2] = "balloon2.gif"
floatr[3] = "balloon3.gif"
floatr[4] = "balloon4.gif"
floatr[5] = "balloon5.gif"
floatr[6] = "balloon6.gif"
floatr[7] = "balloon7.gif"


var ns4up = (document.layers) ? 1 : 0;  // browser sniffer
var ie4up = (document.all) ? 1 : 0;
var ns6up = (document.getElementById&&!document.all) ? 1 : 0;
var dx, xp, yp;    // coordinate and position variables
var am, stx, sty;  // amplitude and step variables
var i, doc_width = 800, doc_height = 1800;

if (ns4up||ns6up) {
        doc_width = self.innerWidth;
        doc_height = self.innerHeight;
} else if (ie4up) {
        doc_width = document.body.clientWidth;
        doc_height = document.body.clientHeight;
}

dx = new Array();
xp = new Array();
yp = new Array();
am = new Array();
stx = new Array();
sty = new Array();
j = 0;

for (i = 0; i < no; ++ i) {
        dx[i] = 0;                        // set coordinate variables
        xp[i] = Math.random()*(doc_width-50);  // set position variables
        yp[i] = Math.random()*doc_height;
        am[i] = Math.random()*20;         // set amplitude variables
        stx[i] = 0.02 + Math.random()/10; // set step variables
        sty[i] = 0.7 + Math.random();     // set step variables
        if (ns4up) {                      // set layers
                if (i == 0) {
                        document.write("<layer name=\"dot"+ i +"\" left=\"15\" top=\"15\" visibility=\"show\"><img src=\""+ floatr[j] + "\" border=\"0\"></layer>");
                } else {
                        document.write("<layer name=\"dot"+ i +"\" left=\"15\" top=\"15\" visibility=\"show\"><img src=\""+ floatr[j] + "\" border=\"0\"></layer>");
                }        } else if (ie4up||ns6up) {                if (i == 0) 
{
                        document.write("<div id=\"dot"+ i +"\" style=\"POSITION: absolute; Z-INDEX: "+ i +"VISIBILITY: visible; TOP: 15px; LEFT: 15px; width:1;\"><img src=\"" + floatr[j] + "\" border=\"0\"></div>");
                } else {
                        document.write("<div id=\"dot"+ i +"\" style=\"POSITION: absolute; Z-INDEX: "+ i +"VISIBILITY: visible; TOP: 15px; LEFT: 15px; width:1;\"><img src=\"" + floatr[j] + "\" border=\"0\"></div>");
                }
        }
        if (j == (floatr.length-1)) { j = 0; } else { j += 1; }
}

function floatrNS() {  // Netscape main animation function
        for (i = 0; i < no; ++ i) {  // iterate for every dot
                yp[i] -= sty[i];                if (yp[i] < -50) {
                        xp[i] = Math.random()*(doc_width-am[i]-30);
                        yp[i] = doc_height;
                        stx[i] = 0.02 + Math.random()/10;
                        sty[i] = 0.7 + Math.random();
                        doc_width = self.innerWidth;
                        doc_height = self.innerHeight;                }
                dx[i] += stx[i];
                document.layers["dot"+i].top = yp[i]+pageYOffset;
                document.layers["dot"+i].left = xp[i] + 
am[i]*Math.sin(dx[i]);
        }
        setTimeout("floatrNS()", speed);
}

function floatrIE_NS6() {  // IE main animation function
        for (i = 0; i < no; ++ i) {  // iterate for every dot
                yp[i] -= sty[i];
                if (yp[i] < -50) {
                        xp[i] = Math.random()*(doc_width-am[i]-30);
                        yp[i] = doc_height;
                        stx[i] = 0.02 + Math.random()/10;
                        sty[i] = 0.7 + Math.random();
                        doc_width = ns6up?window.innerWidth-5:document.body.clientWidth;
                        doc_height = ns6up?window.innerHeight-5:document.body.clientHeight;
                }
                dx[i] += stx[i];
                if (ie4up){
                document.all["dot"+i].style.pixelTop = yp[i]+document.body.scrollTop;
                document.all["dot"+i].style.pixelLeft = xp[i] + am[i]*Math.sin(dx[i]);
                }
                else if (ns6up){
                document.getElementById("dot"+i).style.top=yp[i]+pageYOffset;
                document.getElementById("dot"+i).style.left=xp[i] + am[i]*Math.sin(dx[i]);
                }
        }
        setTimeout("floatrIE_NS6()", speed);
}

if (ns4up) {
        floatrNS();
} else if (ie4up||ns6up) {
        floatrIE_NS6();
}
// End -->
</script>