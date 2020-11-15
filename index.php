<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="https://code.jquery.com/jquery-3.5.1.slim.js" integrity="sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM=" crossorigin="anonymous"></script>
<title>Jade Delight Part 2</title>
</head>

<body>
<script language="javascript">

function MenuItem(name, cost)
{
	this.name = name;
	this.cost=cost;
}

menuItems = new Array(
	new MenuItem("Chicken Chop Suey", 4.5),
	new MenuItem("Sweet and Sour Pork", 6.25),
	new MenuItem("Shrimp Lo Mein", 5.25),
	new MenuItem("Moo Shi Chicken", 6.5),
	new MenuItem("Fried Rice", 2.35)
);

function makeSelect(name, minRange, maxRange)
{
	var t= "";
	t = "<select name='" + name + "' size='1'>";
	for (j=minRange; j<=maxRange; j++)
	   t += "<option>" + j + "</option>";
	t+= "</select>"; 

	return t;
}

function subTotal(){

	var items = document.getElementsByName("cost")
	var sum = 0

	for (var i = 0; i < 5; i++){
		if (items[i].value){
			sum += parseFloat(items[i].value)
		}
	}	
	
	return (sum - 0).toFixed(2)

}

function massTax(){

	var subtotal = document.getElementById("subtotal").value
	return (0.0625 * subtotal).toFixed(2)
}

function getTotal(){

	var subtotal = document.getElementById("subtotal").value - 0
	var tax = document.getElementById("tax").value - 0
	return (subtotal + tax).toFixed(2)

}

// Binds onChange event handler to each select tag
function addOnChange(){

	for (var i = 0; i < 5; i++){
		var curr_name = "quan" + i
		var temp = 'select[name="quan' + i + '"]'
		$(temp).change(function () {
			var c_name = this.name
			var menu_items = [4.50, 6.25, 5.25, 6.50, 2.35]
			var index = parseInt(c_name.slice(-1))
			var item = document.getElementsByName(c_name)[0]

			var cost_boxes = document.getElementsByName("cost")
			cost_boxes[index].value = (menu_items[index] * item.value).toFixed(2)

			document.getElementById("subtotal").value = subTotal()
			document.getElementById("tax").value = massTax()
			document.getElementById("total").value = getTotal()
		})
	}
}

// determines whether address info should be displayed
function showDFields(){

	var delivery = document.getElementsByName("p_or_d")[1].checked
	var paragraphs = document.getElementsByTagName("p")

	if (delivery){
		paragraphs[2].style.display = "block"
		paragraphs[3].style.display = "block"
	}
	else {
		paragraphs[2].style.display = "none"
		paragraphs[3].style.display = "none"
	}
}

// bind on change handler for radio buttons
function addChecked(){

	var methods = document.getElementsByName("p_or_d")
	for (var i = 0; i < 2; i++){
		methods[i].onchange = showDFields
	}	
}

// Bind on submit handler for form
function addSubmit(){
	$("form").submit(validateForm)
}

// formats date/time as 12 hour clock instead of 24 hour
function formatAMPM(date) {
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'pm' : 'am';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;
  return strTime;
}

function getPickupTime(){
	var d = new Date()
	d.setMinutes(d.getMinutes() + 15)
	return (formatAMPM(d))
}

function getDeliveryTime(){
	var d = new Date()
	d.setMinutes(d.getMinutes() + 30)
	return (formatAMPM(d))	
}

function validateDelivery(){

	var street = (document.getElementsByName("street")[0].value != "")
	var city = (document.getElementsByName("city")[0].value != "")

	if (!(street && city)){
		alert("Street and City fields must be specified")
		return false
	}
	return true
}

function validateLastName(){
	var lname = (document.getElementsByName("lname")[0].value != "")
	if (!lname){
		alert("Last name is required")
		return false
	}
	return true
}

// checks for valid phone number format
function phonenumber (num){
	var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
  	if((num.match(phoneno))){
      return true;
	}
    else {
        return false;
    }
}

// validate user entered phone # and it's correctly formatted
function validatePhone(){
	var phoneNum = document.getElementsByName("phone")[0].value
	var entered = (phoneNum != "")
	if (!entered){
		alert("Phone number is required")
		return false
	}
	else {
		if (!phonenumber(phoneNum)){
			alert("Phone number must be in format XXX-XXX-XXXX, XXX.XXX.XXXX, XXX XXX XXXX,or XXXXXXXXXX")
			return false
		}
		return true
	}
	
}

// concatinates inner HTML for new window validation
function listItems(){

	var items = document.getElementsByTagName("select")
	var chicken = items[0].value
	var pork = items[1].value
	var shrimp = items[2].value
	var moo = items[3].value
	var rice = items[4].value

	var text = "<br/> <p> ORDER SUMMARY <br/> <br/>" + chicken + " Chicken Chop Suey <br/>" + pork +
	 " Sweet and Sour Pork <br/>" + shrimp + " Shrimp Lo Mein <br/>" + moo + " Moo Shi Chicken <br/>"
	 + rice + " Fried Rice </p> <br/>"

	return text

}

function validateForm(){

	if (validateLastName() && validatePhone()){

		if (document.getElementsByName("p_or_d")[0].checked){
            document.getElementById("validated").value = "valid"
		}
		else {
			if (validateDelivery()){
                document.getElementById("validated").value = "valid"
			}
		}
	}
}

</script>

<h1>Jade Delight</h1>
<form method ="get" action = "action.php">

<p>First Name: <input type="text"  name='fname' /></p>
<p>Last Name*:  <input type="text"  name='lname' /></p>
<p>Street: <input type="text"  name='street'/></p>
<p>City: <input type="text"  name='city' /></p>
<p>Phone*: <input type="text"  name='phone' /></p>
<p>Email: <input type="text"  name='email' /></p>
<p> 
	<input type="radio"  name="p_or_d" value = "pickup" checked="checked"/>Pickup  
	<input type="radio"  name='p_or_d' value = 'delivery'/>
	Delivery
</p>
<table border="0" cellpadding="3">
  <tr>
    <th>Select Item</th>
    <th>Item Name</th>
    <th>Cost Each</th>
    <th>Total Cost</th>
  </tr>
<script language="javascript">

  var s = "";
  for (i=0; i< menuItems.length; i++)
  {
	  s += "<tr><td>";
	  s += makeSelect("quan" + i, 0, 10);
	  s += "</td><td>" + menuItems[i].name + "</td>";
	  s += "<td> $ " + menuItems[i].cost.toFixed(2) + "</td>";
	  s += "<td>$<input type='text' name='cost'/></td></tr>";
  }
  document.writeln(s);
</script>
</table>
<p>Subtotal: 
   $<input type="text"  name='subtotal' id="subtotal" value = "0.00"/>
</p>
<p>Mass tax 6.25%:
  $ <input type="text"  name='tax' id="tax" value = "0.00"/>
</p>
<p>Total: $ <input type="text"  name='total' id="total" value = "0.00"/>
</p>

<p style="display: none">&nbsp <input type="text"  name='pickuptime' id="pickuptime" />
</p>

<p style="display: none">&nbsp <input type="text"  name='validated' id="validated" value = "invalid"/>
</p>

<input type = "submit" value = "Submit Order" />
</form>
<script>
	addOnChange()
	addChecked()
	showDFields()
	addSubmit()
</script>
</body>
</html>