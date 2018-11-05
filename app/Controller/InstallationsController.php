                          $result = $sql->get_result();
//var_dump($result);die;
//var_dump($sql->fetch_assoc());die;

                                if ($sql->num_rows > 0) {

                                        $insert = "";
                                        $type = $sql->fetch_assoc()['type'];

                                        if ($type == "List" || $type == "Multi-Select List") {

                                                $insert .= "[!Options!]";
                                                // $items = explode(",", $value2);

                                                for ($i = 0; $i < sizeof($value2); $i++){
                                                        $insert .= trim($value2[$i]);

                                                        if (($i+1) != sizeof($value2)) {
                                                                $insert .= "[!]";
                                                        }
                                                }

                                                $insert .= "[!Options!]";

                                                $sql = $conn->prepare(
                                                        "UPDATE kora3_fields
                                                        SET options = ?
                                                        where name = ? and pid = ?"
                                                );
                                                $sql->bind_param('sss', $insert, $newKey, $pid);
                                                $sql->execute();
                                        }
                                }
                        }
                }
                $conn->close();

                //create admin user

                $usersC = new UsersController();

                $mappingProjects = array();
                array_push($mappingProjects, array(
                        'project' => array('name' => $pName, 'pid' => $pid),
                        'role' => array('name' => 'Admin', 'value' => 'Admin')
                ));

                $addUserData = array(
                        'name' => $_SESSION['ArcsConfig']['ArcsAdminName'],
                        'username' => $_SESSION['ArcsConfig']['ArcsAdminUsername'],
                        'email' => $_SESSION['ArcsConfig']['ArcsAdminEmail'],
                        'password' => $_SESSION['ArcsConfig']['ArcsAdminPassword'],
                        'isAdmin' => 1,
                        'last_login' => null,
                        'status' => 'confirmed'
                );

                $response["status"] = $this->User->add($addUserData);
        if ($response["status"] == false) {
                        $response["message"] = $this->User->invalidFields();
                        return $this->json(400, ($response));
                }

        $usersC->editMappings($mappingProjects, array(), $response["status"]['User']['id']);

                //write to bootstrap file so that configured = true

                $path = APP . "Config/bootstrap.php";
                $contents = file_get_contents($path);
                $contents = str_replace(
                        "define('CONFIGURED', 'false');",
                        "define('CONFIGURED', 'true');",
                        $contents
                );
                $contents = str_replace(
                        "'arcs' =>",
                        "'".$pName."' =>",
                        $contents
                );
                $contents = str_replace(
                        'define("BASE_BOTH", "");',
                        'define("BASE_BOTH", "'.$_SESSION['ArcsConfig']['ArcsBaseURL'].'");',
                        $contents
                );
                file_put_contents($path, $contents);

//jecho $content;
//die;

                $this->redirect('/');
        }

    /**
     * Returns Original Label from Permalink URL
     */
    public function periodo()   {
        $url = 'http://n2t.net/ark:/99152/p0d.json';
        $data = file_get_contents($url);
        $out = json_decode($data, true);
        $address = $_POST["input"];
        $key = (explode('/',$address));

        multiKeyExists($out, end($key));

        function multiKeyExists($arr, $key)
        {
            // is in base array?
            if (array_key_exists($key, $arr))
            {
                return json_encode($arr[$key]['label']);
            }

            // check arrays contained in this array
            foreach ($arr as $element)
            {
                if (is_array($element))
                {
                    multiKeyExists($element, $key);
                }
            }
            return false;
        }
    }
}

