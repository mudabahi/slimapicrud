<?php

    class Database
    {
        private $conn = null;
        private $result = array();

        protected function get($sql)
        {
            $this->conn = new mysqli("localhost", "root", "", "post_api");
            
            $res = $this->conn->query($sql);
            if ($res->num_rows > 0) {
                $index = 0;
                while ($row = $res->fetch_object()) {
                    $this->result[$index] = $row;
                    $index++;
                }
            }

            return $this->result;
        }

        protected function insert($sql)
        {
            try {
                $this->conn = new mysqli("localhost", "root", "", "post_api");
                if ($this->conn->query($sql) === TRUE)
                    return $this->conn->insert_id;
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
            return 0;
        }

        protected function update($sql){
            $status = 0;
            $this->conn = new mysqli("localhost", "root", "", "post_api");
            $res = $this->conn->query($sql);
            if($res) return $status = 1;
            return $status;
            
        }

        protected function delete($sql){
            $status = 0;
            $this->conn = new mysqli("localhost", "root", "", "post_api");
            $res = $this->conn->query($sql);
            if($res) return $status = 1;
            return $status;
        }

        protected function getById($sql){
            $this->conn = new mysqli("localhost", "root", "", "post_api");
            $res = $this->conn->query($sql);
            if ($res->num_rows > 0) {
                $this->result = $res->fetch_object();
            }
            return $this->result;
        }

        function apiResponse($response, $payload, $statusCode = 200)
        {
            $payload = json_encode($payload);
            $response->getBody()->write($payload);
            return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', '*')
                ->withHeader('Access-Control-Allow-Credentials', 'true')
                ->withHeader('Content-Type', 'application/json')
                ->withStatus($statusCode);
        }
    }
