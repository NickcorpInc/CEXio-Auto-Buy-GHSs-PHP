CEXio-Auto-Buy-GHSs-PHP
=======================

Automatic buying CEX.io GHSs for BTC and NMC.

To run the script needed PCP. 
I run the script from the command line. 
The script runs in an infinite loop (almost always). 
Once per minute, a request data from the website CEX.io . 
If the balance enough to buy 0.01 GHS - then placed a buy order and started waiting at the bottom of a minute. 
If non-residual balance - wait timer is started (up to three minutes). 

Ps Often that squeaking hangs upon request danyh site - requires restart script. (This problem Comments)
