<?php
if(isset($_POST['content'])){
    $message = $_POST['content'];
}
if(isset($_POST['studentNo'])){
    $mobileNo = $_POST['studentNo'];
}
if(isset($_POST['TemplateId'])){
    $templateid = $_POST['TemplateId'];
}

// echo $message;
// die;

	// Account details
    $apiKey = '21400|AA7XvnY94a2UUJ2JjRmK0slM0J95M2GYhG9jMyLk';
    // Message details
    // $numbers = $mobileNo; // Multiple numbers separated by comma
    $sender = 'VPHSSS';
    // Prepare data for POST request
    $data = 'access_token='.$apiKey.'&to='.$mobileNo.'&message='.$message.'&service=T&sender='.$sender.'&template_id='.$templateid;
    // Send the GET request with cURL
    $url = 'https://sms.messagewall.in/api/v2/sms/send?'.$data; 
    $finalurl = preg_replace("/ /", "%20", $url);
    $response = file_get_contents($finalurl);  
    // Process your response here

    echo $response; 


    //அன்புள்ள மாணவர் அருண், இன்று உங்களுக்கு இனிய நாளாக அமைய வித்யா பார்த்தி மேல்நிலைப்பள்ளி சார்பாக வாழ்த்துகிறோம். இனிய பிறந்தநாள் வாழ்த்துக்கள்.
    //Dear student {#var#}, today is a {#var#} for you. vidhya parthi higher secondary school {#var#}.
    // Dear [Name], today is a special day for you. vidhya parthi higher secondary school wishes you 'Happy birthday'.
    // -தலைமை ஆசிரியை வித்யா பார்த்தி மேல்நிலைப்பள்ளி திண்டுக்கல்.
?>
