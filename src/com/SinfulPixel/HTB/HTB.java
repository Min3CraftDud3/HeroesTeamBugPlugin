package com.SinfulPixel.HTB;

import com.SinfulPixel.HTB.Database.MySQL.MySQL;
import org.apache.commons.lang.StringUtils;
import org.bukkit.Bukkit;
import org.bukkit.ChatColor;
import org.bukkit.command.Command;
import org.bukkit.command.CommandSender;
import org.bukkit.configuration.file.FileConfiguration;
import org.bukkit.entity.Player;
import org.bukkit.plugin.java.JavaPlugin;

import java.io.File;
import java.io.IOException;
import java.sql.*;

/**
 * Created by Min3 on 7/19/2014.
 * Created so that players can submit heroes bugs while in game.
 * Designed to be used with provided web interface.
 */
public class HTB extends JavaPlugin {
    MySQL MySQL = new MySQL(this, getConfig().getString("HTB.MySQL.Host"), getConfig().getString("HTB.MySQL.Port"),
            getConfig().getString("HTB.MySQL.Database"), getConfig().getString("HTB.MySQL.Username"), getConfig().getString("HTB.MySQL.Password"));
    static Connection c = null;
    public static Statement statement = null;
    public void onEnable(){
        //Config Setup.
        try {
            saveConfig();
            setupConfig(getConfig());
            saveConfig();
        } catch (Exception e) {
            e.printStackTrace();
        }
        //MySQL
        try {
                System.out.println("Connecting to Database");
                c = MySQL.openConnection();
                System.out.println("Connecting to Database...CONNECTED!");
                statement = c.createStatement();
                DatabaseMetaData meta = c.getMetaData();
                ResultSet res = meta.getTables(null,null,"BUGS",null);
                if(!res.next()) {
                    System.out.println("Creating Bugs Table.");
                    statement.executeUpdate("CREATE TABLE BUGS (ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, UUID varchar(38) NOT NULL,PNAME varchar(30) NOT NULL, " +
                            "BUG varchar(255));");
                    System.out.println("Creating Core Table...COMPLETE!");
                    c.setAutoCommit(true);
                }
        }catch(Exception i){
            System.out.println("Error Connecting to Database. Please Check your login details.");
            System.out.println("Disabling plugin.");
            Bukkit.getPluginManager().disablePlugin(this);
        }
    }
    private void setupConfig(FileConfiguration config) throws IOException {
        if (!new File(getDataFolder(), "RESET.FILE").exists()) {
            new File(getDataFolder(), "RESET.FILE").createNewFile();
            config.set("HTB.Creator","Min3CraftDud3");
            config.set("HTB.WebSite","http://www.SinfulPixel.com");
            config.set("HTB.MySQL.Warning", "====== MySQL Settings ======");
            config.set("HTB.MySQL.Host", "127.0.0.1");
            config.set("HTB.MySQL.Port", 3306);
            config.set("HTB.MySQL.Database", "minecraft");
            config.set("HTB.MySQL.Username", "UserNameHere");
            config.set("HTB.MySQL.Password", "PassHere");
            config.set("HTB.Site.Warning","====== Site Panel URL ======");
            config.set("HTB.Site.URL", "http://www.sinfulpixel.com/look.php");
            saveConfig();
        }
    }
    @Override
    public boolean onCommand(CommandSender sender, Command command,String label, String[] args) {
        if(label.equalsIgnoreCase("report")){
            if(sender instanceof Player){
                Player p = (Player)sender;
                if(args.length==0){
                    p.sendMessage("Usage: /report <detailed report> | Submit your bug reports this way.");
                }
                if(args.length>0) {
                    try {
                           String arguments = StringUtils.join(args,' ');
                           String stripped = arguments.replaceAll("[-+.^:;,\'\"]","");
                            statement.executeUpdate("INSERT INTO BUGS (UUID,PNAME,BUG)VALUES ('" + p.getUniqueId() + "','" + p.getName() + "','" + stripped + "')");
                            p.sendMessage("Thank you for bringing this issue to our attention.");
                            for (Player pl : Bukkit.getOnlinePlayers()) {
                                if (pl.hasPermission("HTB.CanReceiveReports")) {
                                    pl.sendMessage(ChatColor.AQUA + "A new hero bug has been submitted.");
                                    pl.sendMessage(ChatColor.AQUA + getConfig().getString("HTB.Site.URL"));
                                }
                            }

                    }catch(SQLException ex){ex.printStackTrace();p.sendMessage("Error Submitting Bug Report.");}
                }
            }
        }
        return false;
    }
}
