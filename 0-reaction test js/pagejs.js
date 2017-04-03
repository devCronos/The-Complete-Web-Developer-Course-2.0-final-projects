/**
 * Created by Cronos on 2/6/2017.
 */
var shapeObj=document.getElementById("shape");

/*
function randColor() {

				var letters = "0123456789ABCDEF".split('');
				var color = "#";
				for (var i = 0; i < 6; i++) {
					color += letters[Math.round(Math.random() * 15)];
				} //ends for loop
				return color;


			} // ends getRandomColor Function
*/

function randColor() {
    var available = "1234567890ABCDEF".split('');
    var color = "#";
    for(var i= 0; i<6; i++) {
        color += available[Math.round(Math.random()*15)];
    }
    return color;
}

var clickedTime;
var createdTime;
var reactionTime;

function makeBox() {
//delay (was in ms)
    var time = Math.random()*2000;
//setTimeout param: function(){}, time
    setTimeout(function(){
//coinflip shape
        if (Math.random()>0.5){
            shapeObj.style.borderRadius="50%";
        } else {
            shapeObj.style.borderRadius="0px";
        }
//size times rand
        var coef = 200*(Math.random()+0.5);
        shapeObj.style.width = coef + "px";
        shapeObj.style.height = coef + "px";
//position rand times coeficient
        var top = Math.random()*300;
        var left = Math.random()*600;
        shapeObj.style.top = top + "px";
        shapeObj.style.left = left + "px";

//asign rand color
        shapeObj.style.backgroundColor = randColor();

        shapeObj.style.display="block";
//asign createdTime
        createdTime=Date.now();
    },time);


}
//now you click the thing
shapeObj.onclick=function() {
//asign clickedTime
    clickedTime=Date.now();
//calculate reactionTime
    reactionTime=(clickedTime-createdTime)/1000;
    document.getElementById("timer").innerHTML = "Your Reaction Time is: " + reactionTime + "seconds";
    shapeObj.style.display="none";
    makeBox();

}
makeBox();