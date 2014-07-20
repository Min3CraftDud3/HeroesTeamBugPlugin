package com.SinfulPixel.HTB.Database;

/**
 * Created by Min3 on 7/19/2014.
 */

import com.SinfulPixel.HTB.HTB;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;


public abstract class Database {
    protected HTB plugin;
    protected Database(HTB plugin) {
        this.plugin = plugin;
    }
    public abstract Connection openConnection() throws SQLException, ClassNotFoundException;
    public abstract boolean checkConnection() throws SQLException;
    public abstract Connection getConnection();
    public abstract boolean closeConnection() throws SQLException;
    public abstract ResultSet querySQL(String query) throws SQLException, ClassNotFoundException;
    public abstract int updateSQL(String query) throws SQLException, ClassNotFoundException;
}