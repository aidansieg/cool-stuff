# Aidan Siegel and Maya Akiki
# CS 21 Final Project
# Program is a college search program that allows user to create login, search colleges through user inputs, and add colleges to a favorites list

# main calls college_dict that holds the dictionary containing all of the colleges, states, and sizes. Aidan coded the parts of the program that read through the files and put the dictionary values in list, the error handling for user input, and the loop that prints the colleges and the favorites list. Maya coded the lines for user input and excpetion handling.
def main():

    #function containing dictionary is called
    college_search = college_dict()

    #lists for favorites, state, and size is created
    favorite_list = []
    
    state_list = []
    
    size_list = []

    #loop goes through dictionary for the key:value pairs
    for i, j in college_search.items():

        #loop puts each state in list for states
        if j[0] not in state_list:
            state_list.append(j[0])

        #loop puts each size in list for size
        if j[1] not in size_list:
            size_list.append(j[1])

    print("Welcome to the East Coast college search! \n")

    try:
        welcome = True

        #loop runs as long as user doesnt input 'log out' at end of the program
        while welcome != 'log out':
            welcome = input("Enter '1' if you are a new user or enter '2' if you are a returning user: ")

            #if the user doesnt enter an input that continues the program, they are warned and asked to enter an input again
            while welcome != '1' and welcome != '2':
                print("You must type '1' or '2' \n")
                welcome = input("Enter '1' if you are a new user or enter '2' if you are a returning user: ")

            print("\n")

            #runs if the user enters '1' at begining of program
            if welcome == '1':

                #opens file containing login info
                logins = open("logins.txt", "r")

                #reads through the whole file
                logins = logins.read()
                        
                new_user = input("Create Username: ")

                #if the user name is <= 5 characters, it warns users and lets them re-enter a username
                while len(new_user) <= 5:
                    print("Your username must be greater then 5 characters")
                    new_user = input("Create Username: ")

                #if the user trys to create a username thats already in logins.txt, it warns them and lets them re-enter a new username
                if len(new_user) > 5:
                    for i in logins.split():
                        while new_user in i:
                            print("This user name is already taken")
                            new_user = input("Create Username: ")
                
                new_password = input("Create Password: ")

                #if the password is <= 5 characters, it warns users and lets them re-enter a password
                while len(new_password) <= 5:
                    print("Your password must be greater then 5 characters")
                    new_password = input("Create passowrd: ")

                #opens file containing login info
                save_new_login = open("logins.txt", "a")

                #combines users password and username into a tuple
                new_login = new_user, new_password

                #transforms tuple into string
                us_pw = str(new_login)

                #writes users login info on file
                save_new_login.write("\n")
                save_new_login.write(us_pw)

                #closes file
                save_new_login.close()

                welcome = input("Type '2' to continue: ")

            #if the user entered '2' at begining of program, it comes here
            if welcome == '2':

                #user enters their login info
                user = input("Enter your username: ")
                password = input("Enter your password: ")

                #opens file containing login info
                logins = open("logins.txt", "r")

                #combines user inputs into tuple
                login = user, password

                #transforms tuple into string
                us_pw = str(login)

                #runs if the users login info matches and of the login info in logins.txt
                if us_pw in logins.read():
                    print("\n")

                    stay = "new"

                    #runs if the user enters 'new' at the end of the program to make a new search
                    while stay == "new":

                        #asks for user input for state and makes it case-insensitive
                        state = input("What state would you like to go to college in: ")
                        state = state.upper()

                        #if user input is not a state in state_list, warns user and asks for input again
                        while state not in state_list:
                            print(state.capitalize(), "is not on the east coast")
                            
                            state = input("Please enter another state: ")
                            state = state.upper()

                        size = input("What is your prefered size? (small=1-5999, medium=6-14999, large=15,000+): ")
                        size = size.upper()

                        #if user input is not a size in size_list, warns user and asks for input again
                        while size not in size_list:
                            print(size.capitalize(), "is not a proper size")
                            
                            size = input("Please enter a proper size: ")
                            size = size.upper()

                        #combines both user inputs into a tuple
                        search = (state, size)

                        print("\n")
                        
                        criteria_match = False

                        #if the tuple of both users inputs is in the dictionary, criteria_match = True
                        for i,j in college_search.items():
                            if search == j:
                                criteria_match = True

                        #if the tuple is not in the dictionary, the program comes here  
                        if criteria_match == False:
                            print("There are no", size.lower(), "colleges in", state.capitalize() + ".")

                        #if criteria_match = True, this loop prints all the colleges that match the users input
                        else:
                            print("Here are the", size.lower(), "colleges in", state.capitalize() + ":")
                            for i,j in college_search.items():
                                if search == j:
                                    criteria_match = True
                                    print("•", i)
                                
                        print("\n")

                        favs = input("Type the college name to add to favorites list or press enter to continue: ")

                        #if the user enters anything besides "", it will add it to favorite_list
                        if favs != "":
                            favorite_list.append(favs)

                            print("\n")
                            
                            more_favs = input("Press '1' to add another college or press enter to continue: ")

                            #allows user to add more colleges to favorite_list if they '1'
                            while more_favs == '1' or more_favs != "":
                                favs = input("Enter college name: ")
                                favorite_list.append(favs)
                                
                                print("\n")
                                more_favs = input("Press '1' to add another college or press enter to continue: ")
                        
                        print("\n")
                        
                        col_list = input("Type 'f' if you'd like to see your favorite colleges list or press any other key to skip: ")

                        print("\n")

                        #if the user enters 'f', the program will display all the inputs the user added to their favorite_list
                        if col_list == 'f':
                            print("Here is your favorite colleges list")
                            
                            for i in favorite_list:
                                print("•", i)
                        
                        stay = input("Type 'new' to preform a new search or press type 'log out' to log out: ")

                        #logs the user out of program if they enter 'log out' or sends them back to the search if they enter 'new'
                        if stay == 'log out':
                            favorite_list = []
                        
                else:
                    #prints if the users username or password arent in logins.txt
                    print("Your user name or password is incorrect")
                    print("\n")

    #prints if logins.txt is not found on users computer
    except FileNotFoundError:
        print("logins.txt was not found")
         

#function contains dictionary of colleges, state, and size and returns it to main function. Maya and Aidan both coded the dictionary
def college_dict():
    colleges = {'University of Maine Orono':('MAINE', 'LARGE'),
           'University of Maine Augusta': ('MAINE', 'MEDIUM'),
           'University of Maine Farmington': ('MAINE','SMALL'),
           'University of Maine Fort Kent': ('MAINE', 'SMALL'),
           'University of Maine Machias': ('MAINE', 'SMALL',),
           'University of Maine Presque Isle': ('MAINE','SMALL'),  
           'Maine Maritime Academy': ('MAINE', 'SMALL'),
           'University of Southern Maine': ('MAINE','MEDIUM'),
           'University of New Hampshire': ('NEW HAMPSHIRE','LARGE'),
           'Keene State College': ('NEW HAMPSHIRE', 'SMALL'),
           'Plymouth State College': ('NEW HAMPSHIRE','SMALL'),
           'University of Vermont': ('VERMONT','MEDIUM'),
           'Vermont Technical College': ('VERMONT','SMALL'),
           'Castleton University': ('VERMONT','SMALL'),
           'Northern Vermont University':('VERMONT', 'SMALL'),
           'University of Massachusetts': ('MASSACHUSETTS', 'LARGE'),
           'Bridgewater State University': ('MASSACHUSETTS','MEDIUM'),
           'Fitchburg State University': ('MASSACHUSETTS', 'MEDIUM'),
           'Framingham State University': ('MASSACHUSETTS', 'MEDIUM'),
           'Salem State University': ('MASSACHUSETTS','MEDIUM'),
           'Westfield State University': ('MASSACHUSETTS', 'SMALL'),
           'Worcester State University': ('MASSACHUSETTS','SMALL'),
           'Massachusetts College of Art and Design': ('MASSACHUSETTS', 'SMALL'),
           'Massachusetts College of Liberal Arts':('MASSACHUSETTS', 'SMALL'),
           'Massachusetts Maritime Academy': ('MASSACHUSETTS', 'SMALL'),
           'Rhode Island College': ('RHODE ISLAND','MEDIUM'),
           'University of Rhode Island': ('RHODE ISLAND', 'MEDIUM'),
           'Charter Oak State College': ('CONNECTICUT', 'SMALL'),
           'Connecticut State University': ('CONNECTICUT','SMALL'),
           'University of Connecticut': ('CONNECTICUT', 'LARGE'),
           'State University of New York Buffalo': ('NEW YORK','LARGE'),
           'State University of New York Albany': ('NEW YORK', 'LARGE'),
           'State University of New York Stony Brook':('NEW YORK', 'SMALL'),
           'State University of New York Binghamton': ('NEW YORK', 'LARGE'),
           'Buffalo State College': ('NEW YORK','MEDIUM'),
           'Empire State College': ('NEW YORK', 'MEDIUM'),
           'State University of New York Brockport': ('NEW YORK', 'MEDIUM'),
           'State University of New York Cortland': ('NEW YORK','MEDIUM'),
           'State University of New York Fredonia': ('NEW YORK', 'SMALL'),
           'State University of New York Geneseo': ('NEW YORK','SMALL'),
           'State University of New York New Paltz': ('NEW YORK', 'MEDIUM'),
           'State University of New York Old Westbury': ('NEW YORK','SMALL'),
           'State University of New York Oneonta': ('NEW YORK', 'MEDIUM'),
           'State University of New York Oswego':('NEW YORK', 'MEDIUM'),
           'State University of New York Plattsburgh': ('NEW YORK', 'SMALL'),
           'State University of New York Potsdam': ('NEW YORK','SMALL'),
           'State University of New York Purchase': ('NEW YORK', 'SMALL'),
           'State University of New York Canton': ('NEW YORK', 'SMALL'),
           'State University of New York Cobleskill': ('NEW YORK','SMALL'),
           'State University of New York Delhi': ('NEW YORK', 'SMALL'),
           'State University of New York Farmingdale': ('NEW YORK','MEDIUM'),
           'State University of New York Maritime College': ('NEW YORK', 'SMALL'),
           'Alfred State':('NEW YORK', 'SMALL'),
           'Baruch College': ('NEW YORK', 'LARGE'),
           'Brooklyn College': ('NEW YORK','LARGE'),
           'City College of New York': ('NEW YORK', 'LARGE'),
           'College of Staten Island': ('NEW YORK', 'LARGE'),
           'Hunter College': ('NEW YORK','LARGE'),
           'John Jay College of Criminal Justice': ('NEW YORK', 'MEDIUM'),
           'Lehman College': ('NEW YORK','MEDIUM'),
           'Medgar Evers College': ('NEW YORK', 'MEDIUM'),
           'New York City College of Technology': ('NEW YORK','LARGE'),
           'Queens College': ('NEW YORK', 'LARGE'),
           'York College':('NEW YORK', 'SMALL'),
           'Bloomsburg University of Pennsylvania': ('PENNSYLVANIA', 'MEDIUM'),
           'California University of Pennsylvania': ('PENNSYLVANIA','SMALL'),
           'Cheyney University of Pennsylvania': ('PENNSYLVANIA', 'SMALL'),
           'Clarion University of Pennsylvania': ('PENNSYLVANIA', 'SMALL'),
           'East Stroudsburg University of Pennsylvania': ('PENNSYLVANIA','MEDIUM'),
           'Edinboro University of Pennsylvania': ('PENNSYLVANIA', 'SMALL'),
           'Indiana University of Pennsylvania': ('PENNSYLVANIA','MEDIUM'),
           'Kutztown University of Pennsylvania': ('PENNSYLVANIA', 'MEDIUM'),
           'Lock Haven University of Pennsylvania': ('PENNSYLVANIA','SMALL'),
           'Mansfield University of Pennsylvania': ('PENNSYLVANIA', 'SMALL'),
           'Millersville University of Pennsylvania':('PENNSYLVANIA', 'MEDIUM'),
           'Shippensburg University of Pennsylvania': ('PENNSYLVANIA','MEDIUM'),
           'Slippery Rock University of Pennsylvania': ('PENNSYLVANIA','MEDIUM'),
           'West Chester University of Pennsylvania': ('PENNSYLVANIA', 'LARGE'),
           'Penn State University Park': ('PENNSYLVANIA', 'LARGE'),
           'Penn State Abington': ('PENNSYLVANIA','SMALL'),
           'Penn State Altoona': ('PENNSYLVANIA', 'SMALL'),
           'Penn State Berks': ('PENNSYLVANIA','SMALL'),
           'Penn State Beaver': ('PENNSYLVANIA', 'SMALL'),
           'Penn State Brandywine':('PENNSYLVANIA', 'SMALL'),
           'Penn State Penn State DuBois': ('PENNSYLVANIA', 'SMALL'),
           'Penn State Erie, The Behrend College': ('PENNSYLVANIA','SMALL'),
           'Penn State Fayette': ('PENNSYLVANIA', 'SMALL'),
           'Penn State Greater Allegheny': ('PENNSYLVANIA', 'SMALL'),
           'Penn State Harrisburg': ('PENNSYLVANIA','SMALL'),
           'Penn State Hazleton': ('PENNSYLVANIA', 'SMALL'),
           'Penn State Lehigh Valley': ('PENNSYLVANIA','SMALL'),
           'Penn State Mont Alto': ('PENNSYLVANIA', 'SMALL'),
           'Penn State New Kensington': ('PENNSYLVANIA','SMALL'),
           'Penn State Schuylkill': ('PENNSYLVANIA', 'SMALL'),
           'Penn State Scranton': ('PENNSYLVANIA','SMALL'),
           'Penn State Shenango': ('PENNSYLVANIA', 'SMALL'),
           'Penn State Wilkes-Barre': ('PENNSYLVANIA','SMALL'),
           'Penn State York': ('PENNSYLVANIA', 'SMALL'),
           'Temple University':('PENNSYLVANIA', 'LARGE'),
           'University of Pittsburgh Bradford': ('PENNSYLVANIA', 'SMALL'),
           'University of Pittsburgh Greensburg': ('PENNSYLVANIA','SMALL'),
           'University of Pittsburgh Johnstown': ('PENNSYLVANIA', 'SMALL'),
           'University of Pittsburgh Titusville': ('PENNSYLVANIA', 'SMALL'),
           'University of Pittsburgh': ('PENNSYLVANIA','LARGE'),
           'The College of New Jersey': ('NEW JERSEY','MEDIUM'),
           'Kean University': ('NEW JERSEY', 'LARGE'),
           'Montclair State University': ('NEW JERSEY','LARGE'),
           'New Jersey City University': ('NEW JERSEY', 'MEDIUM'),
           'New Jersey Institute of Technology':('NEW JERSEY', 'MEDIUM'),
           'Ramapo College of New Jersey': ('NEW JERSEY', 'MEDIUM'),
           'Rowan University': ('NEW JERSEY','LARGE'),
           'Rutgers University New Brunswick': ('NEW JERSEY', 'LARGE'),
           'Rutgers University Newark': ('NEW JERSEY', 'MEDIUM'),
           'Rutgers University Camden': ('NEW JERSEY','SMALL'),
           'Stockton University': ('NEW JERSEY', 'MEDIUM'),
           'Thomas Edison State University': ('NEW JERSEY','LARGE'),
           'William Paterson University of NEW JERSEY ': ('NEW JERSEY', 'MEDIUM'),
           'University of Delaware':('DELAWARE', 'LARGE'),
           'Delaware State University': ('DELAWARE', 'SMALL'),
           'Morgan State University': ('MARYLAND','MEDIUM'),
           'Saint Mary\'s College of Maryland': ('MARYLAND', 'SMALL'),
           'University of Maryland College Park': ('MARYLAND', 'LARGE'),
           'Bowie State University': ('MARYLAND','MEDIUM'),
           'Coppin State University': ('MARYLAND', 'SMALL'),
           'Frostburg State University': ('MARYLAND','SMALL'),
           'Salisbury University': ('MARYLAND', 'MEDIUM'),
           'Towson University': ('MARYLAND','LARGE'),
           'University of Baltimore': ('MARYLAND', 'SMALL'),
           'University of Maryland Baltimore':('MARYLAND', 'SMALL'),
           'University of Maryland Baltimore County': ('MARYLAND', 'MEDIUM'),
           'University of Maryland Eastern Shore': ('MARYLAND','SMALL'),
           'University of Maryland University College': ('MARYLAND', 'LARGE'),
           'Christopher Newport Universirty': ('VIRGINIA', 'SMALL'),
           'George Mason University': ('VIRGINIA','LARGE'),
           'James Madison University': ('VIRGINIA', 'LARGE'),
           'Long Wood University': ('VIRGINIA','SMALL'),
           'University of Mary Washington': ('VIRGINIA', 'SMALL'),
           'Norfolk State University': ('VIRGINIA','SMALL'),
           'Old Dominion University': ('VIRGINIA', 'LARGE'),
           'Radford University':('VIRGINIA', 'MEDIUM'),
           'University of Virginia': ('VIRGINIA', 'LARGE'),
           'University of Virginias College at Wise': ('VIRGINIA','SMALL'),
           'Virginia Commonwealth University': ('VIRGINIA', 'LARGE'),
           'Virginia Military Institute': ('VIRGINIA', 'SMALL'),
           'Virginia Polytechnic Institute and State University': ('VIRGINIA','LARGE'),
           'Virginia State University': ('VIRGINIA', 'MEDIUM'),
           'The College of William and Mary': ('VIRGINIA','MEDIUM'),
           'Appalachian State University': ('NORTH CAROLINA', 'LARGE'),
           'Eastern Carolina University':('NORTH CAROLINA', 'LARGE'),
           'Elizabeth City State University': ('NORTH CAROLINA', 'SMALL'),
           'Fayetteville State University': ('NORTH CAROLINA','MEDIUM'),
           'North Carolina A&T State University': ('NORTH CAROLINA', 'MEDIUM'),
           'North Carolina Central University': ('NORTH CAROLINA', 'MEDIUM'),
           'North Carolina State University': ('NORTH CAROLINA','LARGE'),
           'University of North Carolina at Asheville': ('NORTH CAROLINA', 'SMALL'),
           'University of North Carolina at Chapel Hill': ('NORTH CAROLINA','LARGE'),
           'University of North Carolina at Charlotte': ('NORTH CAROLINA', 'LARGE'),
           'University of North Carolina at Greensboro': ('NORTH CAROLINA','LARGE'),
           'University of North Carolina at Pembroke': ('NORTH CAROLINA', 'MEDIUM'),
           'University of North Carolina at Wilmington': ('NORTH CAROLINA','MEDIUM'),
           'University of North Carolina at School of the Arts': ('NORTH CAROLINA', 'SMALL'),
           'Western Carolina University': ('NORTH CAROLINA','MEDIUM'),
           'Winston-Salem State University': ('NORTH CAROLINA', 'SMALL'),
           'The Citadel':('SOUTH CAROLINA', 'SMALL'),
           'Clemson University': ('SOUTH CAROLINA', 'LARGE'),
           'Coastal Carolina University': ('SOUTH CAROLINA','MEDIUM'),
           'College of Charleston': ('SOUTH CAROLINA', 'MEDIUM'),
           'Francis Marion University': ('SOUTH CAROLINA', 'SMALL'),
           'Lander University': ('SOUTH CAROLINA','SMALL'),
           'University of South Carolina Columbia': ('SOUTH CAROLINA', 'LARGE'),
           'University of South Carolina Aiken': ('SOUTH CAROLINA','SMALL'),
           'University of South Carolina Beaufort': ('SOUTH CAROLINA', 'SMALL'),
           'University of South Carolina Lancaster':('SOUTH CAROLINA', 'SMALL'),
           'University of South Carolina Salkehatchie': ('SOUTH CAROLINA','SMALL'),
           'University of South Carolina Sumter': ('SOUTH CAROLINA','SMALL'),
           'University of South Carolina Union': ('SOUTH CAROLINA', 'SMALL'),
           'University of South Carolina Upstate': ('SOUTH CAROLINA', 'SMALL'),
           'South Carolina State University': ('SOUTH CAROLINA','SMALL'),
           'Winthrop University': ('SOUTH CAROLINA', 'MEDIUM'),
           'Abraham Baldwin Agricultural College': ('GEORGIA','SMALL'),
           'Albany State University': ('GEORGIA', 'MEDIUM'),
           'Atlanta Metropolitan State College': ('GEORGIA','SMALL'),
           'Augusta University': ('GEORGIA', 'MEDIUM'),
           'Clayton State University':('GEORGIA', 'MEDIUM'),
           'College of Costal Georgia': ('GEORGIA', 'SMALL'),
           'Columbus State University': ('GEORGIA','MEDIUM'),
           'Dalton State University': ('GEORGIA', 'SMALL'),
           'East Georgia State College': ('GEORGIA', 'SMALL'),
           'Fort Valley State University': ('GEORGIA','SMALL'),
           'Georgia College and State University': ('GEORGIA', 'MEDIUM'),
           'Georgia Gwinnett College': ('GEORGIA','MEDIUM'),
           'Georgia Highlands College': ('GEORGIA', 'SMALL'),
           'Georgia Institute of Technology':('GEORGIA', 'LARGE'),
           'Georgia Southern University': ('GEORGIA', 'LARGE'),
           'Georgia Southwestern State University': ('GEORGIA','SMALL'),
           'Georgia State University': ('GEORGIA', 'LARGE'),
           'Gordon State College': ('GEORGIA', 'SMALL'),
           'Kennesaw State University': ('GEORGIA','LARGE'),
           'Middle Georgia State University': ('GEORGIA', 'MEDIUM'),
           'South Georgia State College': ('GEORGIA','SMALL'),
           'Savannah State University': ('GEORGIA', 'SMALL'),
           'University of Georgia': ('GEORGIA', 'LARGE'),
           'University of North Georgia': ('GEORGIA','LARGE'),
           'University of West Georgia': ('GEORGIA', 'MEDIUM'),
           'Valdosta State University': ('GEORGIA','MEDIUM'),
           'Florida A&M University': ('FLORIDA', 'MEDIUM'),
           'Florida Atlantic University':('FLORIDA', 'LARGE'),
           'Florida Gulf Coast University': ('FLORIDA', 'LARGE'),
           'Florida International University': ('FLORIDA','LARGE'),
           'Florida State University': ('FLORIDA', 'LARGE'),
           'Florida Polytechnic University': ('FLORIDA', 'SMALL'),
           'New College of Florida': ('FLORIDA','SMALL'),
           'University of Central Florida': ('FLORIDA', 'LARGE'),
           'University of Florida': ('FLORIDA','LARGE'),
           'University of North Florida': ('FLORIDA', 'MEDIUM'),
           'University of South Florida':('FLORIDA', 'LARGE'),
           'University of West Florida': ('FLORIDA', 'MEDIUM'),
           'Broward College': ('FLORIDA','LARGE'),
           'Chipola College': ('FLORIDA', 'SMALL'),
           'College of Central Florida': ('FLORIDA', 'MEDIUM'),
           'Dayton State College': ('FLORIDA','MEDIUM'),
           'Eastern Florida State College': ('FLORIDA', 'LARGE'),
           'Florida Gateway College': ('FLORIDA','SMALL'),
           'Florida Southwestern State College': ('FLORIDA', 'LARGE'), 
           'Florida State College at Jacksonville': ('FLORIDA','LARGE'),
           'Gulf Coast State College': ('FLORIDA', 'MEDIUM'),
           'India River State College': ('FLORIDA', 'MEDIUM'),
           'Lake-Sumter State College': ('FLORIDA','MEDIUM'),
           'Miami Dade College': ('FLORIDA', 'MEDIUM'),
           'Northwest Florida State College': ('FLORIDA','MEDIUM'),
           'Palm Beach State College': ('FLORIDA', 'LARGE'),
           'Pasco-Hernando State College':('FLORIDA', 'MEDIUM'),
           'Pensacola State College': ('FLORIDA', 'LARGE'),
           'Polk State College': ('FLORIDA','LARGE'),
           'Santa Fe College': ('FLORIDA', 'LARGE'),
           'Seminole State College of Florida': ('FLORIDA', 'LARGE'),
           'South Florida State College': ('FLORIDA','SMALL'),
           'St. Johns River State College': ('FLORIDA', 'MEDIUM'),
           'St. Petersburg College': ('FLORIDA','LARGE'),
           'State College Florida, Manatee-Sarasota': ('FLORIDA', 'MEDIUM'),
           'Tallahassee Community College': ('FLORIDA','LARGE'),
           'Valencia College': ('FLORIDA', 'LARGE')
     
           }

    return colleges

main()



