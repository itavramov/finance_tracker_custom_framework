#Template devops folder for web app

# Install and setup project

Install project in VM (use vagrant and VirtualBox and provision with Ansible).

## Requirements

Ubuntu 18.04 , Git, Git-flow

## Setup required software

Make sure that you have all required software installed. For further instructions on this follow this [link](https://bitbucket.upnetix.com/projects/DEVOPS/repos/setup-tools/browse).

## Setup project

Clone source code from BitBucket for your project for example in directory named `{_project-name_}`

    git clone ssh://git@bitbucket.upnetix.com:7999/project_name.git project-name
    
Clone source code from BitBucket for example in directory, named devops-template

If you have a SSH key to your account

    git clone ssh://git@bitbucket.upnetix.com:7999/devops/devops-template.git
    
Otherwise use 

    git clone https://user.name@bitbucket.upnetix.com/scm/devops/devops-template.git
    
Copy `devops-template` directory into your project root directory. Rename it to devops.

**NB!** Do not copy hidden .git directory.
    
## Setup devops for your project
 
Open file `devops/env/shared-vars.yml`
   
Replace `project_name` variable with the name of your project. **Please keep in mind that this would be use for creating project domain. 
Do not use empty spaces or underscore. If you use dot (.) this will be replaced with dash (-)**

In `project_root` variable replace `{devops_template}` string with the name of your project. 
This is the directory that will be created for your project on the VM.

If you have database dump that needs to be imported you have to create a zip file and place it in `devops/provision/files/`. 
In this folder you will find the file `sample.zip` , if you have your own file, you may delete the sample file.

In `devops/env/shared-vars.yml` set proper value for `database_source_file_name` variable.

**NB!!!** By default the webserver is configured to look for public directory into your project route. 
If your main index failed is not placed in such directory you must add `"project_document_root"` to your _shared_vars.yml_ file and configure it with correct relative path for your index file.

## Env variables

As you have already seen in `devops/env/` folder there two files - `shared-vars.yml` and `shared_vault.yml` and tree folders named - `dev`, `live`, `test`.

Purpose of `shared_vars.yml` is to hold all variables that would be shared for all existing environments.

Variables that will be different for different environments should be placed in file `all.yml` which is placed in folder `group_vars` for each environment. 

**Please keep in mind that variables placed in these files will override the variables form `shared_vars.yml` with the same name.**

Purpose of `shared-vault.yml` is pretty much the same. The difference is that this file is encrypted with ansilbe vault and protected with password. 
All kind of sensitive data as passwords and tokens for third part services, must be kept in this file. For more information on asnible vault follow this [link](https://docs.ansible.com/ansible/latest/user_guide/vault.html). 

You will find the default vault password in the file `vault_pass`.
If you want to change it, please keep in mind that you will have to figure out how to share it with the team.
Respectively for each environment dev/live/test there is a file named `vault.yml` that holds environment specific encrypted variables. 
**In those files you will find the database credentials. Use different password for each environment**

## Create the VM with dev environment

In console open `devops` dir in your project.
If you follow the rule to place all of your projects in folder Projects in your home directory, the following command must work when you replace `{project_name}` with the name of your project:

    cd ~/Projects/{project-name}/devops
    
In this directory you will find a bash script named run.sh. In order to create and manage your VM you will have to execute it with the following command:
    
    ./run.sh
    
Once executed the script provides 10 different options:

 1) Start
 2) Start Home
 3) Provision
 4) Build
 5) Build with provision
 6) Setup
 7) SSH
 8) Stop
 9) Destroy
10) Quit

### First step 
To start the VM 

    Run options 1 or 2, 
    
Dependent on you are at the office or you are working from home. <br/>
**Remember that to use devops from home, you must be connected to the VPN**<br/>
If you have installed [Vargant file system notification forwarder plugin](https://github.com/mhallin/vagrant-notify-forwarder) you may get the following error __terminate called after throwing an instance of 'std::runtime_error' what():  Could not add watch_. If that happens you will have to terminate the process with _Ctrl+C_ and start run.sh script again.
In case that you do not have the plugin installed you will be asked to choose your next step. 

### Step two
    
    Run option 3 - Provision.
     
At this point your VM is being configured and all basic roles needed for your webserver and dbserver are being installed. 

You can find list with those roles in `devops/provision/playbooks_ folder`. All this roles are placed in bitbucket repositories that you can find [here](https://bitbucket.upnetix.com/projects/DEVOPS).
Exact repos can be found in `devops/provision/requirements.yml`.

Every role has it's own variables defined that can be overwritten in your var files. You will find those variables described in each role readme file.

If you need to create your own role you must put it in `devops/provision/roles` folder.<br>
You can see everything that is being executed on step 3 defined in file `devops/provision/provision.yml`<br>
**Keep in mind that provisioning can take a while, when you are creating new machine.**

### Step three

    Run option 5 - Build with provision.
     
At the step composer and nodejs are being installed on your VM. 
You can see the nodejs's packages installed globally by default in `devops/build/vars/main.yml`.

If you do not need either composer or nodejs it is better to remove the relevant role from `devops/build/build.yml` and also remove the task from `devops/build/roles/build/tasks/main.yml`.

In that file you can see everything that is being executed with the Build option. <br>
If you have composer dependencies, they would be loaded at this step. <br>

**NB!!!** If your composer.json is not in the project root directory you must change  `working_dir` for composer task in `devops/build/roles/build/tasks/main.yml` . 

If your project requires gulp build, you need to uncomment the second task in `devops/build/roles/build/tasks/main.yml` and make sure that the path in args is correct and leading to the folder where your `gulpfile` is placed. Check also var `nodejs_package_json_path` in `devops/build/vars/main.yml`.


### The last step 
For initial setup of your VM
 
    Run option 6 - Setup.
     
At this step there are two default roles - one for running your database migrations and the others is to create project's config file.

For further information about DB migrations check the readme file [here](https://bitbucket.upnetix.com/projects/DEVOPS/repos/ansible-role-mysql-db-migrations/browse). <br>
**NB!!!** If you do not have any migrations yet or if you are using project specific migration logic you must comment or remove the role in _devops/provision/setup.yml_.

Template for the config file is placed in `/devops/provision/roles/app_setup/templates` and is called .env. 
This file is placed here just for example. It is possible your file to be named differently and to have much more variables in it.

**NB!!!** In `devops/provision/roles/app_setup/tasks/main.yml` you will find the task that creates config file on your VM. You must modify the path and file name to fit your project needs. <br>

### Exit 
To exit the script you can 

    Run option 10 - Exit. or use Crtl+C

At this point if you have done everything right you should have a running VM and should be able to access your project using url composed by your username and project name

    https://{your_username}-{project_name}.upnetix.tech/

##Further use of your VM

Once you have created your VM there are some other steps from the run script that you may find useful.

**Option 7 - SSH** - While your VM is up and running, you can use this option to ssh into it and check what is going on. Using this option you will login directly in your project folder on the VM.

**Option 8 - Stop**  - It is a good practice to stop your VM from running at the end of the working day. You can start it again with option 1 or option 2.

**Option 9 - Destroy** - You can use this option to destroy your VM which means that it would be deleted and can't be restored to it's current status, so if you have made changes in the database that are not made via migrations, they would be lost. 

**NB** If you destroy your VM and need to use it again afterward you must go all the way through initial setup again.

If you need to make some changes to your VM after it is created, you will need to modify ansible roles and run again either option `3 - Provision`, option `4 - Build` or option `6 - Setup`, dependent on what role you have changed.<br>

Remember that `6 - Setup` step overwrites your config file, so you must always add your changes to the template file before running option 6.

## Home office specifics

This setup is made to be used either from upnetix office or via VPN. If you need to work from home or other location you need to make sure that you have VPN connection to the office set up.

To start your VM from home you must use option `2 - Start Home`. When you choose that option the script will ask for your root password. This is because the script is modifying the `/etc/hosts` file on your computer.

At this point script is creating a record in this file so your browser can resolve your url and open your project.

**NB!!! When you get back in the office, you must erease this record from `etc/hosts` file**.