from __future__ import print_function
import tweepy
import json
import MySQLdb 
from dateutil import parser
import config

#import datetime
from datetime import datetime
from datetime import timedelta

WORDS = ['#awalidengankebersihan', '#cleanthecity', '#cleanthecity2020']

CONSUMER_KEY = config.consumer_key
CONSUMER_SECRET = config.consumer_secret 
ACCESS_TOKEN = config.access_token
ACCESS_TOKEN_SECRET = config.access_secret

HOST = config.host
USER = config.user
PASSWD = config.passwd
DATABASE = config.database

# This function takes the 'created_at', 'text', 'screen_name' and 'tweet_id' and stores it
# into a MySQL database
def store_data(created_at, text, screen_name, tweet_id, location, name, following, followers_count, statuses_count, gps_location):
    
    db = MySQLdb.connect(host=HOST, user=USER, passwd=PASSWD, db=DATABASE, charset="utf8mb4")
    cursor = db.cursor()
    insert_query = "INSERT INTO tweet_capture (tweet_id, screen_name, created_at, text, location, name, following, followers_count, statuses_count,gps_location) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
    cursor.execute(insert_query, (tweet_id, screen_name, created_at, text, location, name, following, followers_count, statuses_count, gps_location))
    db.commit()
    cursor.close()
    db.close()
    return

class StreamListener(tweepy.StreamListener):    
    #This is a class provided by tweepy to access the Twitter Streaming API. 

    def on_connect(self):
        # Called initially to connect to the Streaming API
        print("You are now connected to the streaming API.")
 
    def on_error(self, status_code):
        # On error - if an error occurs, display the error / status code
        print('An Error has occured: ' + repr(status_code))
        return False
 
    def on_data(self, data):
        #This is the meat of the script...it connects to your mongoDB and stores the tweet

        try:
           # Decode the JSON from Twitter
            datajson = json.loads(data)
            
            #grab the wanted data from the Tweet
            text = datajson['text']
            screen_name = datajson['user']['screen_name']
            #reply_count
            
            #user
            #statuses_count
            #followers_count
            #location
            tweet_id = datajson['id']
            #id_name = datajson['user']['id_str']
            location = datajson['user']['location']
            name = datajson['user']['name']
            # lat,lon
            gps_location = "0,0" #"%s,%s" % (datajson['geo']['coordinates'][0],datajson['geo']['coordinates'][1])
            if datajson['coordinates']:
                gps_location = str(datajson['coordinates'][datajson['coordinates'].keys()[1]][1]) + ", " + str(datajson['coordinates'][datajson['coordinates'].keys()[1]][0]) 
            
            following = datajson['user']['friends_count']
            followers_count = datajson['user']['followers_count']
            statuses_count = datajson['user']['statuses_count']
            
            #created_at = parser.parse(datajson['created_at'])
			
	    clean_timestamp = datetime.strptime(datajson['created_at'], '%a %b %d %H:%M:%S +0000 %Y')
			
            offset_hours = 7 #offset in hours for EST timezone

	    #account for offset from UTC using timedelta                                
	    local_timestamp = clean_timestamp + timedelta(hours=offset_hours)

	    #convert to am/pm format for easy reading
            created_at =  datetime.strftime(local_timestamp, '%Y-%m-%d %H:%M:%S')  
			
			#clean_timestamp = datetime.strptime(datajson['created_at'], '%a %b %d %H:%M:%S +0000 %Y')
			
			#offset_hours = 7 #offset in hours for EST timezone

			#account for offset from UTC using timedelta                                
			#local_timestamp = clean_timestamp + timedelta(hours=offset_hours)

			#convert to am/pm format for easy reading
			#created_at =  datetime.strftime(local_timestamp, '%Y-%m-%d %I:%M:%S %p')  

            #print out a message to the screen that we have collected a tweet
            #print("Tweet collected at " + str(created_at))
            
            #insert the data into the MySQL database
            store_data(created_at, text, screen_name, tweet_id, location, name, following, followers_count, statuses_count, gps_location)
        
        except Exception as e:
            print(e)

			
auth = tweepy.OAuthHandler(CONSUMER_KEY, CONSUMER_SECRET)

auth.set_access_token(ACCESS_TOKEN, ACCESS_TOKEN_SECRET)

#Set up the listener. The 'wait_on_rate_limit=True' is needed to help with Twitter API rate limiting.
listener = StreamListener(api = tweepy.API(wait_on_rate_limit=True))

streamer = tweepy.Stream(auth=auth, listener=listener)

print("Tracking: " + str(WORDS))

streamer.filter(track=WORDS)

