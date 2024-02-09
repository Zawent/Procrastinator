package co.edu.procastinadont;

import android.app.ActivityManager;
import android.content.Context;
import android.content.Intent;
import android.content.pm.ApplicationInfo;
import android.content.pm.PackageManager;
import android.os.Handler;
import android.util.Log;
import android.app.Service;
import android.content.Intent;
import android.os.Handler;
import android.os.IBinder;
import android.util.Log;
import java.util.List;
import androidx.annotation.Nullable;
import androidx.localbroadcastmanager.content.LocalBroadcastManager;



public class PrimeroService extends Service {
    private static final String TAG = "Primero";
    private Handler handler;
    private final int INTERVALO_ACTUALIZACION = 3000;


    @Override
    public void onCreate() {
        super.onCreate();
        handler = new Handler();
        handler.postDelayed(actualizarAppEnPrimerPlano, INTERVALO_ACTUALIZACION);
    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        return START_STICKY;
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        handler.removeCallbacks(actualizarAppEnPrimerPlano);
    }

    @Nullable
    @Override
    public IBinder onBind(Intent intent) {
        return null;
    }

    private Runnable actualizarAppEnPrimerPlano = new Runnable() {
        @Override
        public void run() {
            String appPrimerPlano = Primero();
            Log.d(TAG, "App en primer plano: " + appPrimerPlano);
            Intent intent = new Intent("AppPrimera");
            intent.putExtra("appEnPrimerPlano", appPrimerPlano);
            LocalBroadcastManager.getInstance(getApplicationContext()).sendBroadcast(intent);

            handler.postDelayed(this, INTERVALO_ACTUALIZACION);
        }
    };

    public String Primero() {
        ActivityManager activityManager = (ActivityManager) getSystemService(Context.ACTIVITY_SERVICE);
        List<ActivityManager.RunningAppProcessInfo> appProcesses = activityManager.getRunningAppProcesses();
        PackageManager packageManager = getPackageManager();

        if (appProcesses != null && !appProcesses.isEmpty()) {
            for (ActivityManager.RunningAppProcessInfo appProcess : appProcesses) {
                if (appProcess.importance == ActivityManager.RunningAppProcessInfo.IMPORTANCE_FOREGROUND) {
                    try {
                        ApplicationInfo appInfo = packageManager.getApplicationInfo(appProcess.processName, PackageManager.GET_META_DATA);
                        CharSequence appName = packageManager.getApplicationLabel(appInfo);
                        return appName.toString();
                    } catch (PackageManager.NameNotFoundException e) {
                        e.printStackTrace();
                    }
                }
            }
        }
        return null;
    }
}
