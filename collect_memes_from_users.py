##################################
# Collect memes from other users #
##################################
# Every user can make a directory /user/<USERNAME>/public_html/memes and put memes in there.
# This script will check that directory for every user and copy its contents to a specified destination.


import sys
import os
import argparse
from pathlib import Path


def check_folder_size(folder):
    path = Path(folder)
    size = sum(f.stat().st_size for f in path.glob('**/*') if f.is_file())
    return size

if __name__=='__main__':

  # input arguments
  parser = argparse.ArgumentParser(description='Collect memes from users')
  parser.add_argument('-u', '--users', default=['all'], nargs='+',
                      help='List of user names to scan over (default: all users in /user)')
  parser.add_argument('-p', '--path', default='public_html/memes',
                      help='Subfolder within each user home directory (default: public_html/memes)')
  parser.add_argument('-d', '--destination', default='auto',
                      help='Location where to put the memes (default: /user/$USER/args.path)')
  parser.add_argument('-e', '--extensions', default=['.png'], nargs='+',
                      help='File extensions to consider (default: only .png)')
  parser.add_argument('-v', '--verbose', default=False, action='store_true',
                      help='Do more printouts for debugging')
  args = parser.parse_args()

  # print arguments
  print('Running with following configuration:')
  for arg in vars(args):
    print('  - {}: {}'.format(arg,getattr(args,arg)))

  # parse users
  users = args.users
  if 'all' in args.users: users = sorted(os.listdir('/user/'))
  if args.verbose:
    print('Found following user names:')
    print(users)

  # parse destination
  destination = args.destination
  if destination=='auto':
    destination = os.path.join('/user', os.environ['USER'], args.path)
  if args.verbose:
    print('Configured following destination:')
    print(destination)

  # check initial size of destination
  destination_size = check_folder_size(destination)
  print('Initial disk size of destination: {:.3g} MB'.format(destination_size/1024**2)) 

  # parse input paths
  paths = []
  for user in users:
    path = os.path.join('/user', user, args.path)
    # check if path exists
    if not os.path.exists(path):
      if args.verbose:
        msg = 'WARNING: path {} does not exist; skipping...'.format(path)
        print(msg)
      continue
    # check if path is equal to destination
    if os.path.abspath(path)==os.path.abspath(destination):
      if args.verbose:
        msg = 'WARNING: path {} is equal to destination; skipping...'.format(path)
        print(msg)
      continue
    paths.append(path)
  if args.verbose:
    print('Found following input paths:')
    print(paths)

  # make destination if it does not exist yet,
  # and read its current contents if it already exists
  if not os.path.exists(destination): os.makedirs(destination)
  contents = os.listdir(destination)

  # loop over input paths
  for path in paths:
    if args.verbose: print('Now checking contents of {}...'.format(path))
    
    # find contents
    pathcontents = os.listdir(path)
    if args.verbose: print('Number of files: {}'.format(len(pathcontents)))
    
    # filter on file extension
    memes = ([ meme for meme in pathcontents if( os.path.splitext(meme)[1] in args.extensions ) ])
    if args.verbose: print('Nubmer of files after extension filter: {}'.format(len(memes)))

    # loop over memes
    for meme in memes:

      # make output file name and check if it is already in the destination
      outputfilename = os.path.join(path, meme).replace('/','')
      if outputfilename in contents: continue

      # make and execute the copy command
      inputfile = os.path.join(path, meme)
      outputfile = os.path.join(destination, outputfilename)
      cmd = 'cp {} {}'.format(inputfile, outputfile)
      if args.verbose: print(cmd)
      os.system(cmd)

      # check intermediate size of destination
      destination_size = check_folder_size(destination)
      destination_gb = destination_size/1024**3
      if destination_gb > 1:
        msg = 'ERROR: size of destination folder reached quotum, skip remaining copies.'
        print(msg)
        break

  # check initial size of destination
  destination_size = check_folder_size(destination)
  print('Final disk size of destination: {:.3g} MB'.format(destination_size/1024**2))
