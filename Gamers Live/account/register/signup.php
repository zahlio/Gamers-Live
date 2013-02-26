<?php

//error_reporting(0);
$display_name = $_POST['display_name'];
$email = $_POST['email'];
$channel_id = $_POST['channel_id'];
$password = $_POST['password'];
$checked = "0";
$checked1 = "0";

// check if indput is valid
if($display_name == ""){
	header('Location: http://gamers-live.net/account/register/?msg=Please enter a valid display name');
}else{
	if($email == ""){
		header('Location: http://gamers-live.net/account/register/?msg=Please enter a valid email');
	}else{
		if($channel_id == ""){
			header('Location: http://gamers-live.net/account/register/?msg=Please enter a valid channel name');
		}else{
			if($password == ""){
				header('Location: http://gamers-live.net/account/register/?msg=Please enter a valid password');
			}else{
				$checked = "1";
			}				
		}
	}
}

// we first get data from our mysql database
$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";

// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());
			
// select thje database we need
$select_db = mysql_select_db("live", $connect) or die(mysql_error());
			
if($checked == "1"){		
	$result = mysql_query("SELECT * FROM users WHERE channel_id='$channel_id'") or die(mysq_error());
	$count = mysql_num_rows($result);
	
	if($count != 0){
		header('Location: http://gamers-live.net/account/register/?msg=Please choose another channel name, as the one you entered is already in use');
	}else{
		// we will now check the email		
		$result_email = mysql_query("SELECT * FROM users WHERE email='$email'") or die(mysq_error());
		$count_email = mysql_num_rows($result_email);
		if($count_email != 0){
			header('Location: http://gamers-live.net/account/register/?msg=The email is already in use');
		}else{
			$checked2 = "1";	
		}
	}
	

}
$date = date("Y-m-d");
$time = time();
$stream_key = $time;
		
if($checked2 == "1"){
	// if that is not true we can create the user
	
		// but first we will generate the stream key
		
	$create_user = mysql_query("INSERT INTO users (display_name, email, password, channel_id, reg_date, active) VALUES ('$display_name', '$email', '$password', '$channel_id', '$date', '0')") or die(mysq_error());
	$create_channel = mysql_query("INSERT INTO channels (channel_id, server_rtmp, game, stream_key, title, info1, info2, info3) VALUES ('$channel_id', 'rtmp://gamers-live.net/', 'Other', '$stream_key', '$channel_id', 'No Info', 'No Info', 'No Info')") or die(mysql_error());
	
	// create channel dir
	mkdir("/xampp/htdocs/user/".$channel_id."/");

	// copy channel files from test
	copy("/xampp/htdocs/user/test/index.php","/xampp/htdocs/user/".$channel_id."/index.php");
	copy("/xampp/htdocs/user/test/offline_img.png","/xampp/htdocs/user/".$channel_id."/offline_img.png");
	copy("/xampp/htdocs/user/test/header.png","/xampp/htdocs/user/".$channel_id."/header.png");
	copy("/xampp/htdocs/user/test/avatar.png","/xampp/htdocs/user/".$channel_id."/avatar.png");

	// create application dir
	mkdir("/live/applications/".$channel_id."/");
	
	// create app conf dir
	mkdir("/live/conf/".$channel_id."/");
	
	// copy application files from test
		// we have none
	
	// copy app conf from test
	copy("/live/conf/test/Application.xml","/live/conf/".$channel_id."/Application.xml");
	
	
	$sxe = new SimpleXMLElement('<Root>
	<Application>
		<!-- Uncomment to set application level timeout values
		<ApplicationTimeout>60000</ApplicationTimeout>
		<PingTimeout>12000</PingTimeout>
		<ValidationFrequency>8000</ValidationFrequency>
		<MaximumPendingWriteBytes>0</MaximumPendingWriteBytes>
		<MaximumSetBufferTime>60000</MaximumSetBufferTime>
		<MaximumStorageDirDepth>25</MaximumStorageDirDepth>
		-->
		<Connections>
			<AutoAccept>true</AutoAccept>
			<AllowDomains></AllowDomains>
		</Connections>
		<!--
			StorageDir path variables
			
			${com.wowza.wms.AppHome} - Application home directory
			${com.wowza.wms.ConfigHome} - Configuration home directory
			${com.wowza.wms.context.VHost} - Virtual host name
			${com.wowza.wms.context.VHostConfigHome} - Virtual host config directory
			${com.wowza.wms.context.Application} - Application name
			${com.wowza.wms.context.ApplicationInstance} - Application instance name
			
		-->
		<Streams>
			<StreamType>live</StreamType>
			<StorageDir>${com.wowza.wms.context.VHostConfigHome}/content</StorageDir>
			<KeyDir>${com.wowza.wms.context.VHostConfigHome}/keys</KeyDir>
			<!-- LiveStreamPacketizers (separate with commas): cupertinostreamingpacketizer, smoothstreamingpacketizer, sanjosestreamingpacketizer, cupertinostreamingrepeater, smoothstreamingrepeater, sanjosestreamingrepeater -->
			<LiveStreamPacketizers>cupertinostreamingpacketizer,smoothstreamingpacketizer,sanjosestreamingpacketizer</LiveStreamPacketizers>			
			<!-- Properties defined here will override any properties defined in conf/Streams.xml for any streams types loaded by this application -->
			<Properties>
			</Properties>
		</Streams>
		<Transcoder>
			<!-- To turn on transcoder set to: transcoder -->
			<LiveStreamTranscoder></LiveStreamTranscoder>
			<!-- [templatename].xml or ${SourceStreamName}.xml -->
			<Templates>${SourceStreamName}.xml,transrate.xml</Templates>
			<ProfileDir>${com.wowza.wms.context.VHostConfigHome}/transcoder/profiles</ProfileDir>
			<TemplateDir>${com.wowza.wms.context.VHostConfigHome}/transcoder/templates</TemplateDir>
			<Properties>
			</Properties>
		</Transcoder>

		<DVR>
			<!-- As a single server or as an origin, use dvrstreamingpacketizer in LiveStreamPacketizers above -->
			<!-- Or, in an origin-edge configuration, edges use dvrstreamingrepeater in LiveStreamPacketizers above -->
			<!-- As an origin, also add dvrchunkstreaming to HTTPStreamers below -->

			<!-- To turn on DVR recording set Recorders to dvrrecorder.  This works with dvrstreamingpacketizer  -->
			<Recorders></Recorders>

			<!-- As a single server or as an origin, set the Store to dvrfilestorage-->
			<!-- edges should have this empty -->
			<Store></Store>

			<!--  Window Duration is length of live DVR window in seconds.  0 means the window is never trimmed. -->
			<WindowDuration>0</WindowDuration>

			<!-- Storage Directory is top level location where dvr is stored.  e.g. c:/temp/dvr -->
			<StorageDir>${com.wowza.wms.context.VHostConfigHome}/dvr</StorageDir>

			<!-- valid ArchiveStrategy values are append, version, delete -->
			<ArchiveStrategy>append</ArchiveStrategy>

			<!-- If this is a dvrstreamingrepeater, define ChunkOriginURL to point back to origin -->
			<!-- And define Application/Repeater/OriginURL to point back to the origin -->
			<Repeater>
				<ChunkOriginURL></ChunkOriginURL>
			</Repeater>

			<!-- Properties for DVR -->
			<Properties>
			</Properties>
		</DVR>

		<TimedText>
			<!-- VOD caption providers (separate with commas): vodcaptionprovidermp4_3gpp, vodcaptionproviderttml, vodcaptionprovidersrt, vodcaptionproviderscc -->
			<VODTimedTextProviders>vodcaptionprovidermp4_3gpp</VODTimedTextProviders>
			
			<!-- Properties for TimedText -->
			<Properties>
			</Properties>		
		</TimedText>		

		<!-- HTTPStreamers (separate with commas): cupertinostreaming, smoothstreaming, sanjosestreaming, dvrchunkstreaming -->
		<HTTPStreamers>cupertinostreaming,smoothstreaming,sanjosestreaming</HTTPStreamers>			
		<SharedObjects>
			<StorageDir></StorageDir>
		</SharedObjects>
		<Client>
			<IdleFrequency>-1</IdleFrequency>
			<Access>
				<StreamReadAccess>*</StreamReadAccess>
				<StreamWriteAccess>*</StreamWriteAccess>
				<StreamAudioSampleAccess></StreamAudioSampleAccess>
				<StreamVideoSampleAccess></StreamVideoSampleAccess>
				<SharedObjectReadAccess>*</SharedObjectReadAccess>
				<SharedObjectWriteAccess>*</SharedObjectWriteAccess>
			</Access>
		</Client>
		<RTP>
			<!-- RTP/Authentication/[type]Methods defined in Authentication.xml. Default setup includes; none, basic, digest -->
			<Authentication>
				<PublishMethod>digest</PublishMethod>
				<PlayMethod>none</PlayMethod>
			</Authentication>
			<!-- RTP/AVSyncMethod. Valid values are: senderreport, systemclock, rtptimecode -->
			<AVSyncMethod>senderreport</AVSyncMethod>
			<MaxRTCPWaitTime>12000</MaxRTCPWaitTime>
			<IdleFrequency>75</IdleFrequency>
			<RTSPSessionTimeout>90000</RTSPSessionTimeout>
			<RTSPMaximumPendingWriteBytes>0</RTSPMaximumPendingWriteBytes>
			<RTSPBindIpAddress></RTSPBindIpAddress>
			<RTSPConnectionIpAddress>0.0.0.0</RTSPConnectionIpAddress>
			<RTSPOriginIpAddress>127.0.0.1</RTSPOriginIpAddress>
			<IncomingDatagramPortRanges>*</IncomingDatagramPortRanges>
			<!-- Properties defined here will override any properties defined in conf/RTP.xml for any depacketizers loaded by this application -->
			<Properties>
			</Properties>
		</RTP>
		<MediaCaster>
			<RTP>
				<RTSP>
					<!-- udp, interleave -->
					<RTPTransportMode>interleave</RTPTransportMode>
				</RTSP>
			</RTP>
			<!-- Properties defined here will override any properties defined in conf/MediaCasters.xml for any MediaCasters loaded by this applications -->
			<Properties>
			</Properties>
		</MediaCaster>
		<MediaReader>
			<!-- Properties defined here will override any properties defined in conf/MediaReaders.xml for any MediaReaders loaded by this applications -->
			<Properties>
			</Properties>
		</MediaReader>
		<MediaWriter>
			<!-- Properties defined here will override any properties defined in conf/MediaWriter.xml for any MediaWriter loaded by this applications -->
			<Properties>
			</Properties>
		</MediaWriter>
		<LiveStreamPacketizer>
			<!-- Properties defined here will override any properties defined in conf/LiveStreamPacketizers.xml for any LiveStreamPacketizers loaded by this applications -->
			<Properties>
			</Properties>
		</LiveStreamPacketizer>
		<HTTPStreamer>
			<!-- Properties defined here will override any properties defined in conf/HTTPStreamers.xml for any HTTPStreamer loaded by this applications -->
			<Properties>
			</Properties>
		</HTTPStreamer>
		<Repeater>
			<OriginURL></OriginURL>
			<QueryString><![CDATA[]]></QueryString>
		</Repeater> 
		<Modules>
			<Module>
				<Name>base</Name>
				<Description>Base</Description>
				<Class>com.wowza.wms.module.ModuleCore</Class>
			</Module>
			<Module>
				<Name>properties</Name>
				<Description>Properties</Description>
				<Class>com.wowza.wms.module.ModuleProperties</Class>
			</Module>
			<Module>
				<Name>logging</Name>
				<Description>Client Logging</Description>
				<Class>com.wowza.wms.module.ModuleClientLogging</Class>
			</Module>
			<Module>
				<Name>flvplayback</Name>
				<Description>FLVPlayback</Description>
				<Class>com.wowza.wms.module.ModuleFLVPlayback</Class>
			</Module>
			<Module>
				<Name>ModuleSecureURLParams</Name>
				<Description>ModuleSecureURLParams</Description>
				<Class>com.wowza.wms.security.ModuleSecureURLParams</Class>
			</Module>
		</Modules>
		<!-- Properties defined here will be added to the IApplication.getProperties() and IApplicationInstance.getProperties() collections -->
		<Properties>
		</Properties>
	</Application>
</Root>'); //In this line it create a SimpleXMLElement object with the source of the XML file. 
	//The following lines will add a new child and others child inside the previous child created.
	$propNode = $sxe->xpath('/Root/Application/Properties');
	$properties = $propNode[0]->addChild('Property'); ;
		$properties->addChild("Name", "secureurlparams.publish"); 
		$properties->addChild("Value", "".$stream_key.".streamKey");
	
	//This next line will overwrite the original XML file with new data added 
	$sxe->asXML("/live/conf/".$channel_id."/Application.xml");
	
	// redict user to the login screen
	
	header('Location: http://gamers-live.net/account/activate/email.php?email='.$email.'');
}

?>