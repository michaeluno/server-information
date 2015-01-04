'''''''''''''''''''''''';;;''''''''''''''''''''''''
' WordPress Repository Deployment Git to SVN 1.0.0
' 
' Usage: 
' 1. [Important] Set necessary path and repository slug in the configuration file: settings.ini in the same directory to this script.
' 2. (optional)  Set the SVN ignore list in the svnignore.txt located in the same directory to this script.
' 3. Run 'deploy.vbs'
' 
' Requirements:
'   Make sure your system can operate the following commands Some of them may be installed with Git for Windows (http://git-scm.com/download/win): 
'    - grep
'    - gawk
'    - xargs
'    - git
'''''''''''''''''''''''';;;''''''''''''''''''''''''

' The script title for the prompt window title.
sScriptTitle        = "WordPress Repository Deployment Git to SVN"


' Shell object
Dim oWshShell
Set oWshShell       = CreateObject( "WScript.Shell" )


' Default variables
sCurrentDirPath     = oWshShell.CurrentDirectory
sConfigFilePath     = oWshShell.CurrentDirectory & "\settings.ini"


' Get the system temporary path
Set colEnvironment  = oWshShell.Environment( "PROCESS" )
sTempDirPath        = colEnvironment( "temp" )


' Get default values 
sSVNUserName        = trim( ReadIni( sConfigFilePath, "SVN", "user_name" ) )        
If Len( sSVNUserName ) = 0 Then
    sSVNUserName = InputBox( "Enter the wordpress.org SVN repository user name e.g. myusername" )
    If Len( sSVNUserName ) = 0 Then
        MsgBox "A remote SVN user name is required. The script exits.", 16, sScriptTitle
        Wscript.Quit
    End If
End If


' Repository (plugin/script) slug
sScriptSlug         = trim( ReadIni( sConfigFilePath, "Script", "slug" ) )
If Len( sScriptSlug ) = 0 Then
    sScriptSlug = InputBox( "Enter the repository slug e.g. my-plugin-slug" )
    If Len( sScriptSlug ) = 0 Then
        MsgBox "A repository slug is required. The script exits.", 16, sScriptTitle
        Wscript.Quit
    End If    
End If


' The remote repository address. No trailing slash.
sSVNURL              = trim( ReadIni( sConfigFilePath, "SVN", "url" ) )
If Len( sSVNURL ) = 0 Then
    sSVNURL          = "http://plugins.svn.wordpress.org/" & sScriptSlug
End If


' The path to a local directory where a temporary SVN checkout can be made.
sTempSVNDirPath      = sTempDirPath & "\" & sScriptSlug  
sTempSVNDirPathWQ    = chr( 34 ) & sTempSVNDirPath & chr( 34 )
sTempSVNTrunkDirWQ   = chr( 34 ) & sTempSVNDirPath & "/trunk" & chr( 34 )
sTempSVNTagsDir      = sTempSVNDirPath & "/tags"
sTempSVNTagsDirWQ    = chr( 34 ) & sTempSVNDirPath & "/tags" & chr( 34 )

' The local working directory path. No trailing slush.
sWorkingCopyDirPath  = trim( ReadIni( sConfigFilePath, "Path", "working_copy_dir" ) )
sWorkingCopyDirPath  = getFullPath( sWorkingCopyDirPath )
If Len( sWorkingCopyDirPath ) = 0 Then
    sWorkingCopyDirPath  = sCurrentDirPath & "/" & sScriptSlug
End If

' The repository main file
sMainFileName  = trim( ReadIni( sConfigFilePath, "Path", "main_file_name" ) )
If Len( sMainFileName ) = 0 Then
    sMainFileName  = sScriptSlug & ".php"
End If

' Confirmation Dialog
iMsgBoxResult = MsgBox( "Is this information correct?" & vbNewLine & vbNewLine _
    & "Script Slug:" & vbNewLine & sScriptSlug & vbNewLine & vbNewLine _
    & "Remove SVN Repository:" & vbNewLine & sSVNURL & vbNewLine & vbNewLine _
    & "SVN User Name:" & vbNewLine & sSVNUserName & vbNewLine & vbNewLine _
    & "Local Working Directory:" & vbNewLine & sWorkingCopyDirPath & vbNewLine & vbNewLine _
    & "Main File Name:" & vbNewLine & sMainFileName & vbNewLine & vbNewLine _   
    , 36 _
    , sScriptTitle )

if iMsgBoxResult = 7 Then 
    MsgBox "The script exits.", 16, sScriptTitle
    Wscript.Quit
End If    


'' Done with user input.

' Git configuration
sGitDirPath             = sWorkingCopyDirPath & "/" 
sGitDirPathWQ           = chr( 34 ) & sWorkingCopyDirPath & "/" & chr( 34 )


' Check if the stable version in readme.txt is the same as the one indicated in the plugin file.
sReadmePathWQ           = chr( 34 ) & sGitDirPath & "/readme.txt" & chr( 34 )
sCommand                = "grep " & chr( 34 ) & "^Stable tag:" & chr( 34 ) & " " & sReadmePathWQ & " | gawk -F' ' '{print $NF}' | tr -d '\r'"
sStableVersion          = getConsoleOutput( sCommand )
sPluginMainFIlePathWQ   = chr( 34 ) & sGitDirPath & "/" & sMainFileName & chr( 34 )
sCommand                = "grep " & chr( 34 ) & "Version:" & chr( 34 ) & " " & sPluginMainFIlePathWQ & " | gawk -F' ' '{print $NF}' | tr -d '\r'"
sCurrentVersion         = getConsoleOutput( sCommand )
if sStableVersion <> sCurrentVersion Then 
    MsgBox "The versions do not match. The script exits." & vbNewLine _ 
        & "Stable version (readme.txt): " & sStableVersion & vbNewLine _
        & "Main file version: " & sCurrentVersion _
        , 16 _
        , sScriptTitle
    Wscript.Quit
End If


' Check if the tag of the current version exists or not. If exists, stop proceeding.
sCommand       = "cd /d " & sGitDirPathWQ & "& "_
    & "git show-ref --tags --verify -- " & chr( 34 ) & "refs/tags/" & sCurrentVersion & chr( 34 )
sOutput        = getConsoleOutput( sCommand )
If Not InStr( 1, sOutput, "fatal" ) = 1 Then
    MsgBox "The tag " & sStableVersion &  " already exits. The script exits.", 16, sScriptTitle
    Wscript.Quit
End If


' Git Push
ProgressMsg "Pushing git master to origin, with tags.", sScriptTitle
sCommand = "cmd /K " _ 
    & "cd /d " & sGitDirPath & " & " _
    & "git push origin master & " _
    & "git push origin master --tags"
oWshShell.run sCommand, 1, true

' SVN Checkout
ProgressMsg "Creating a local copy of SVN repository trunk.", sScriptTitle
sCommand            = "cmd /K " _ 
    & "svn checkout " & sSVNURL & " " & sTempSVNDirPathWQ & " --depth immediates & " _
    & "cd /d " & sTempSVNDirPathWQ & " & " _
    & "svn update --quiet " & sTempSVNTrunkDirWQ & " --set-depth infinity"
oWshShell.run sCommand, 1, true


' SVN Ignore files
ProgressMsg "Applying an ignoring list to the SVN 'trunk' directory.", sScriptTitle
sIgnoreFileName      = trim( ReadIni( sConfigFilePath, "SVN", "ignore_file_name" ) )
sIgnoreFilePathWQ    = chr( 34 ) & sCurrentDirPath & "\" & sIgnoreFileName & chr( 34 )
sCommand = "cmd /K " _ 
    & "svn propset svn:ignore -F " & sIgnoreFilePathWQ & " " & sTempSVNTrunkDirWQ
oWshShell.run sCommand, 1, true


' Export - not exactly export as the export-ignore list does not take effect
ProgressMsg "Exporting the HEAD of master from git to the trunk of SVN.", sScriptTitle
sCommand = "cmd /K " _ 
    & "cd /d " & sGitDirPath & " & " _
    & "git checkout-index -a -f --prefix=" & sTempSVNTrunkDirWQ
WshShell.run sCommand, 1, true

' @todo If submodule exist, recursively check out their indexes
sModuleFilePath  = sGitDirPath & "\.gitmodules" & 
if fileExists( sModuleFilePath ) Then 
    ' @todo "Export the HEAD of each submodule from git to the trunk of SVN"
End If    


' SVN Commit to Trunk
ProgressMsg "Changing the directory to SVN and committing to trunk.", sScriptTitle
sCommitMessage = "Preparing for " & sCurrentVersion & " release."
sCommand = "cmd /K " _ 
    & "cd /d " & sTempSVNTrunkDirWQ & " & " _
    & "svn status | grep -v " & chr( 34 ) & "^.[ \t]*\..*" & chr( 34 ) & " | grep " & chr( 34 ) & "^\!" & chr( 34 ) & " | gawk '{print $2}' | xargs svn del & " _  ' Delete all files that should not be added.
    & "svn status | grep -v " & chr( 34 ) & "^.[ \t]*\..*" & chr( 34 ) & " | grep " & chr( 34 ) & "^?" & chr( 34 ) & " | gawk '{print $2}' | xargs svn add & "  _     ' Add all new files that are not set to be ignored. 
    & "svn commit --username=" & sSVNUserName & " -m " & chr( 34 ) & sCommitMessage & chr( 34 )
 

' New SVN Tag and Commit
ProgressMsg "Creating new SVN tag and committing it.", sScriptTitle
sCommitMessage              = "Tagging version " & sCurrentVersion & "."
sTempSVNNewVersionTagDirWQ  = chr( 34 ) & sTempSVNTagsDir & "\" sCurrentVersion & chr( 34 )
sSVNTagAssetDirPathWQ       = chr( 34 ) & sTempSVNTagsDir & "\" sCurrentVersion & "\assets" & chr( 34 )
sSVNTagTrunkDirPathWQ       = chr( 34 ) & sTempSVNTagsDir & "\" sCurrentVersion & "\trunk" & chr( 34 )
sCommand = "cmd /K " _ 
    & "cd /d " & sTempSVNDirPath & " & " _  ' change directory to the SVN temp working copy root
    & "svn update --quiet " & sTempSVNNewVersionTagDirWQ & " & " _
    & "svn copy --quiet " & sTempSVNTrunkDirWQ & " " & sTempSVNNewVersionTagDirWQ & " & "_
    & "svn delete --force --quiet " & sSVNTagAssetDirPathWQ & " & " _    ' Remove assets directory from tag directory
    & "svn delete --force --quiet " & sSVNTagTrunkDirPathWQ & " & " _    ' Remove trunk directory from tag directory
    & "cd /d " & sTempSVNNewVersionTagDirWQ & " & " _
    & "svn commit --username=" & sSVNUserName & " -m " & chr( 34 ) & sCommitMessage & chr( 34 )
    
' Clean up
ProgressMsg "Removing the temporary directory: " & sTempSVNDirPath, sScriptTitle    
sCommand = "cmd /K " _ 
    & "rd /s /q " & sTempSVNDirPath     ' remove the temporary SVN working copy directory

' Exit the script.
Set oWshShell = Nothing
MsgBox "Done"
Wscript.Quit


''''''''' Functions '''''''''

' see http://www.robvanderwoude.com/vbstech_files_ini.php
Function ReadIni( myFilePath, mySection, myKey )
    ' This function returns a value read from an INI file
    '
    ' Arguments:
    ' myFilePath  [string]  the (path and) file name of the INI file
    ' mySection   [string]  the section in the INI file to be searched
    ' myKey       [string]  the key whose value is to be returned
    '
    ' Returns:
    ' the [string] value for the specified key in the specified section
    '
    ' CAVEAT:     Will return a space if key exists but value is blank
    '
    ' Written by Keith Lacelle
    ' Modified by Denis St-Pierre and Rob van der Woude

    Const ForReading   = 1
    Const ForWriting   = 2
    Const ForAppending = 8

    Dim intEqualPos
    Dim objFSO, objIniFile
    Dim strFilePath, strKey, strLeftString, strLine, strSection

    Set objFSO = CreateObject( "Scripting.FileSystemObject" )

    ReadIni     = ""
    strFilePath = Trim( myFilePath )
    strSection  = Trim( mySection )
    strKey      = Trim( myKey )

    If objFSO.FileExists( strFilePath ) Then
        Set objIniFile = objFSO.OpenTextFile( strFilePath, ForReading, False )
        Do While objIniFile.AtEndOfStream = False
            strLine = Trim( objIniFile.ReadLine )

            ' Check if section is found in the current line
            If LCase( strLine ) = "[" & LCase( strSection ) & "]" Then
                strLine = Trim( objIniFile.ReadLine )

                ' Parse lines until the next section is reached
                Do While Left( strLine, 1 ) <> "["
                    ' Find position of equal sign in the line
                    intEqualPos = InStr( 1, strLine, "=", 1 )
                    If intEqualPos > 0 Then
                        strLeftString = Trim( Left( strLine, intEqualPos - 1 ) )
                        ' Check if item is found in the current line
                        If LCase( strLeftString ) = LCase( strKey ) Then
                            ReadIni = Trim( Mid( strLine, intEqualPos + 1 ) )
                            ' In case the item exists but value is blank
                            If ReadIni = "" Then
                                ReadIni = " "
                            End If
                            ' Abort loop when item is found
                            Exit Do
                        End If
                    End If

                    ' Abort if the end of the INI file is reached
                    If objIniFile.AtEndOfStream Then Exit Do

                    ' Continue with next line
                    strLine = Trim( objIniFile.ReadLine )
                Loop
            Exit Do
            End If
        Loop
        objIniFile.Close
    Else
        WScript.Echo strFilePath & " doesn't exists. Exiting..."
        Wscript.Quit 1
    End If
End Function

' Returns the full path.
' @remark       Do not enclose the path in double quotes.
Function getFullPath( sPath )

    Dim oFSO
    Set oFSO = CreateObject( "Scripting.FileSystemObject" )
    getFullPath = oFSO.GetAbsolutePathName( sPath )

End Function

' Checks the file existence
' @remark       Do not enclose the path in double quotes.
Function fileExists( sPath )
    Dim oFSO
    Set oFSO = CreateObject( "Scripting.FileSystemObject" ) 
    If oFSO.FileExists( sPath ) Then
        fileExists = true
    Else    
        fileExists = false
    End If
End Function

Function getConsoleOutput( sCommand )
    
 ''   Dim sText
 '   sText               = ""
 '   Set oShell          = WScript.CreateObject( "WScript.Shell" )
 '   Set oExecObject     = oShell.Exec( "cmd /c " & sCommand )
 '   Do While Not oExecObject.StdOut.AtEndOfStream
 '       sText = sText & oExecObject.StdOut.ReadLine()
 '   Loop
 '   getConsoleOutput    = sText

    Dim oShell, oCmdExec
    Set oShell       = CreateObject( "WScript.Shell" )
    Set oCmdExec     = oShell.exec( "cmd /c " & sCommand )
    getConsoleOutput = trim( oCmdExec.StdOut.ReadAll )
    
End Function

Function ProgressMsg( strMessage, strWindowTitle )
' Written by Denis St-Pierre
' Displays a progress message box that the originating script can kill in both 2k and XP
' If StrMessage is blank, take down previous progress message box
' Using 4096 in Msgbox below makes the progress message float on top of things
' CAVEAT: You must have   Dim ObjProgressMsg   at the top of your script for this to work as described
    Set wshShell = WScript.CreateObject( "WScript.Shell" )
    strTEMP = wshShell.ExpandEnvironmentStrings( "%TEMP%" )
    If strMessage = "" Then
        ' Disable Error Checking in case objProgressMsg doesn't exists yet
        On Error Resume Next
        ' Kill ProgressMsg
        objProgressMsg.Terminate( )
        ' Re-enable Error Checking
        On Error Goto 0
        Exit Function
    End If
    Set objFSO = CreateObject("Scripting.FileSystemObject")
    strTempVBS = strTEMP + "\" & "Message.vbs"     'Control File for reboot

    ' Create Message.vbs, True=overwrite
    Set objTempMessage = objFSO.CreateTextFile( strTempVBS, True )
    objTempMessage.WriteLine( "MsgBox""" & strMessage & """, 4096, """ & strWindowTitle & """" )
    objTempMessage.Close

    ' Disable Error Checking in case objProgressMsg doesn't exists yet
    On Error Resume Next
    ' Kills the Previous ProgressMsg
    objProgressMsg.Terminate( )
    ' Re-enable Error Checking
    On Error Goto 0

    ' Trigger objProgressMsg and keep an object on it
    Set objProgressMsg = WshShell.Exec( "%windir%\system32\wscript.exe " & strTempVBS )

    Set wshShell = Nothing
    Set objFSO   = Nothing
End Function