# mobtexting-sms-module-plugin-for-vtiger #

## Step 0 - Make sure this is for you ##

First [download the install kit (v.2.1)](https://github.com/mobtexting/mobtexting-sms-module-plugin-for-vtiger/archive/master.zip) and test if this code works for you.
If the module installed fine, than you are ready to go. I will try to give some basic steps on how to build this. Follow the steps but also the code showed on github.

## Step 1 - The manifest file ##

Create an empty folder which will hold all the files. Generally I will refer to this folder as `root`.
First thing we need is the `manifest.xml` file. This file is required and the module name is `SMSNotifier`.


## Step 2 - The module class ##

Create a folder named `modules` in the `root` folder and inside create folders `SMSNotifier\providers\` under the file `MOBTexting.php` and you need to handle Vtiger events, also add `SMSNotifierHandler.php` file in `SMSNotifier\` under the folder.


## Step 3 - Adding the language file ##

Next step is to add the language file so, Create a folder named languages and put it inside the `root` folder. Inside languages put another folder named `en_us` and place inside it the file `SMSNotifier.php`. It is required to make the `en_us` folder and also create a new folder as `Settings\` inside it the file `SMSNotifier.php`. For other languages use the specific code, eg. `de_de, en_gb, es_es, ro_ro etc`.


## Step 4 - Adding a module template (layout) ##

You need to create a certain file structure, `\root\layouts\v7\modules\Settings\SMSNotifier\`. Inside the last folder there will be to files: `BaseProviderEditFields.tpl` and `MobTexting.tpl`


## Step 5 - Creating the zip package ##

Now that we have all the files needed, let's just create the final package. When inside the `root` folder, select all the files and create an archive.
When viewing the archive contents, `manifest.xml` and the other folders need to be directly visible (no other folders in between). Do NOT archive the `root` folder itself.


## Step 6 - See in in action ##

Create a new organization (or change an existing one). When the event vtiger.entity.aftersave is triggered, the data will be passed to the event handler in the module.

## Step 7 - Flow ##
	* manifest.xml needs to be present
	* Vtiger version in the manifest file must meet the minimum criteria defined by the Vtiger version you are running
	* language file needs to be present
	* files inside the package must have a certain structure in folders;
	  not having the expected structure leads to confusing error messages
	* language file name must fit the module name.

## Vtiger CRM Steps: ##
	
1) Vtiger CRM is available as both Open Source so [download](https://www.vtiger.com/open-source-crm/download-open-source/) it first and install.

2) After installed, login admin panel and you can see left side `setting / CRM Setting` so open that option.

  	<img src="/images/image1.jpg" >
3) Next `module management` page it will open , choose `modules` any one option.

	<img src="/images/image2.jpg">

4) Next page Right side top you can see the `Import Module from zip` button click and open.

	<img src="/images/image3.jpg">
	
5) It will open a new  page then select the `accept` option and then it will ask which zip file you would like to install so choose the `module zip file` after click the import button.

	<img src="/images/image4.jpg">

6) It will give a warning of `SMS Notifier Exits` don't worry about that juct select the `Update Now` button it will be installing.

	<img src="/images/image5.jpg">
	
7) After installed hover on `SMS Notifier` setting it will show `Setting` button Click and open `Server configuration`.

	<img src="/images/image6.jpg">
	
8) Then,you can see on right side top `New Configuration` button open it.

	<img src="/images/image7.jpg">
	
9) Select the `provider` option of  `MOBTexting`,
   Then give the `access token,service,sender` all are mandatory fields.
   
	<img src="/images/image8.png">   

10) Finally select Active `yes` and save it,Then use `MOBtexting SMS Provider`.

    Enjoy! `(*_*) (^.^)`. . .
