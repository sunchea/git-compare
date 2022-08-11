{"version":3,"file":"core_canvas.min.js","sources":["core_canvas.js"],"names":["window","BX","E","FormToArray","form","data","i","ii","_data","n","elements","length","files","el","disabled","type","toLowerCase","push","name","value","size","checked","j","options","selected","current","p","indexOf","substring","rest","pp","filesCount","roughSize","CanvasEditor","id","this","previewSize","width","height","minWidth","minHeight","dialogName","canvas","Canvas","addCustomEvent","delegate","params","changeCoeff","props","style","parseInt","replace","cover","pos","getCanvas","parentNode","cover1","ratio","coeff","cnv","UploaderUtils","scaleImage","hasAttribute","setAttribute","getAttribute","removeAttribute","setProps","top","Math","ceil","left","right","cover2","paddingTop","paddingBottom","paddingLeft","paddingRight","adjust","destin","padding","max","bottom","popup","prototype","onApply","apply","onCustomEvent","orig","onCancel","onDelete","showEditor","template","res","GetWindowInnerSize","innerWidth","innerHeight","editorNode","create","attrs","className","display","html","message","join","func","replaceChild","bind","proxy","rotate","flip","crop","proxy_context","blackAndWhite","poster","close","removeCustomEvent","func3","PopupWindowManager","autoHide","lightShadow","closeIcon","closeByEsc","zIndex","content","overlay","events","onPopupClose","reset","buttons","PopupWindowButton","text","click","func2","copyCanvas","innerHTML","defer_proxy","toUpperCase","tagName","focus","show","adjustPosition","copy","replaceCanvas","ctx","init","getVisFromReal","prop","c","getRealFromVis","setStyles","styles","recalcCoeff","getContext","initDnD","clearRect","drawImage","node","posterPopup","PopupWindow","offsetTop","offsetLeft","defaultOptions","popupOverlayZindex","popupZindex","bindOptions","position","destroy","onPopupDestroy","msg","posterApply","setAngle","forceBindPosition","min","fillStyle","fillRect","strokeStyle","border","strokeRect","textAlign","textBaseline","font","fillText","frame","getImageData","v","putImageData","verticaly","save","scale","translate","restore","clockwise","turn","tmpCanvas","rad","PI","resize","_imageDropped","url","x","y","drawBorder","img","load","ratioX","ratioY","lineWidth","document","body","removeChild","src","appendChild","DD","isDomNode","cnvDD","dropFiles","supported","ajax","FormData","isSupported","preventDefault","e","fixEventPageXY","dt","dataTransfer","pageX","pageY","types","contains","getData","file","reader","FileReader","onload","target","result","readAsDataURL","cropParams","button","addClass","cropBox","mousedown","layerX","layerY","offsetX","offsetY","mousemove","borderLeft","borderRight","borderTop","borderBottom","mouseup","PreventDefault","clear","removeClass","unbind","_position","isNaN"],"mappings":"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"}