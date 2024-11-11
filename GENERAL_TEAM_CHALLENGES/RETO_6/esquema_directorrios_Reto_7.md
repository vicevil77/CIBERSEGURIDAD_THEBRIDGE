```mermaid
graph LR
  root[10.0.2.15]
  corp[corp]
  corp --> config.local
  corp --> connect
  corp --> csv
  corp --> foo
  corp --> img2
  corp --> incl
  corp --> index_01
  corp --> jscript
  corp --> license_afl
  corp --> README
  corp --> ur-admin
  root --> index.php
  root --> role
  root --> service
  root --> staticpages
  root --> static
  wap[wap]
  wap --> index.php
  wap --> license_afl
  root --> war
  root --> webapps

  ```