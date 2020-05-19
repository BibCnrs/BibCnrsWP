function flipflop(id)
{
	if (!document.getElementById('bibDiscContent-'+id+'').style.display || document.getElementById('bibDiscContent-'+id+'').style.display == "none")
			document.getElementById('bibDiscContent-'+id+'').style.display = "block";
	else	document.getElementById('bibDiscContent-'+id+'').style.display = "none";
}
