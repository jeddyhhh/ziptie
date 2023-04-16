<?php
shell_exec("export TERM=xterm");
echo passthru('/usr/bin/top -b -n 1');
?>