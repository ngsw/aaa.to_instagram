TABLE="${1}"
echo "
CREATE TABLE \`${TABLE}\` (
  \`id\` int(11) NOT NULL auto_increment,
  \`url\` varchar(255) character set ascii default NULL,
  \`alt\` varchar(255) default NULL,
  \`link\` varchar(255) character set ascii default NULL,
  \`linkindex\` varchar(255) character set ascii default NULL,
  \`created_time\` datetime default NULL,
  PRIMARY KEY  (\`id\`),
  UNIQUE KEY \`url\` (\`linkindex\`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
" 
