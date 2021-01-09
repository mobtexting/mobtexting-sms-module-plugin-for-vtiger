# mobtexting-sms-module-plugin-for-vtiger#

## Step 0 - Make sure this is for you ##

First [download the install kit (v.2.1)](https://github.com/mobtexting/mobtexting-sms-module-plugin-for-vtiger/) and test if this code works for you.
If the module installed fine, than you are ready to go. I will try to give some basic steps on how to build this. Follow the steps but also the code showed on github.

## Step 1 - The manifest file ##

Create an empty folder which will hold all the files. Generally I will refer to this folder as root.
First thing we need is the "manifest.xml" file. This file is required and the module name is SMSNotifier.


## Step 2 - The module class ##

Create a folder named Modules in the root folder and inside create folders "SMSNotifier\providers\" under the file "MOBTexting.php" and you need to handle Vtiger events, also add "SMSNotifierHandler.php" file in "SMSNotifier\" under the folder.


## Step 3 - Adding the language file ##

Next step is to add the language file so, Create a folder named languages and put it inside the root folder. Inside languages put another folder named en_us and place inside it the file "SMSNotifier.php". It is required to make the en_us folder and also create a new folder as "Settings\" inside it the file "SMSNotifier.php". For other languages use the specific code, eg. de_de, en_gb, es_es, ro_ro etc.


## Step 4 - Adding a module template (layout) ##

You need to create a certain file structure, "\root\layouts\v7\modules\Settings\SMSNotifier\". Inside the last folder there will be to files: "BaseProviderEditFields.tpl" and "MobTexting.tpl"


## Step 5 - Creating the zip package ##

Now that we have all the files needed, let's just create the final package. When inside the root folder, select all the files and create an archive.
When viewing the archive contents, "manifest.xml" and the other folders need to be directly visible (no other folders in between). Do NOT archive the root folder itself.


## Step 6 - See in in action ##

Create a new organization (or change an existing one). When the event vtiger.entity.aftersave is triggered, the data will be passed to the event handler in the module.

## Step 7 - Flow ##
	* manifest.xml needs to be present
	* Vtiger version in the manifest file must meet the minimum criteria defined by the Vtiger version you are running
	* language file needs to be present
	* files inside the package must have a certain structure in folders; not having the expected structure leads to confusing error messages
	* language file name must fit the module name.
