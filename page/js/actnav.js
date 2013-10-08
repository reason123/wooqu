function selectType(){
	switch(parseInt($("#type-select")[0].options[$("#type-select")[0].selectedIndex].value)){
	case -1:
		break;
	case 0:
		window.location.href="/homepage/newnormalact";
		break;
	case 1:
		window.location.href="/";
		break;
	}
}
